// Canvasを使って画像を再生成（Exif削除 ＆ 圧縮 ＆ クリーン化）
function processViaCanvas(file, quality) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        const url = URL.createObjectURL(file);
        img.onload = () => {
            const canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0);
            canvas.toBlob((blob) => {
                URL.revokeObjectURL(url); // メモリ解放
                resolve(blob);
            }, 'image/jpeg', quality);
        };
        img.onerror = (err) => {
            URL.revokeObjectURL(url);
            reject(err);
        };
        img.src = url;
    });
}

window.convToProcessedImage = async function(file) {
    if (!file) return null;

    const fileName = file.name.toLowerCase();
    const isHeic = fileName.endsWith(".heic");
    // image/jpeg, image/png などの判定
    const isNormalImage = file.type.startsWith("image/");

    if (!isHeic && !isNormalImage) {
        return { previewUrl: URL.createObjectURL(file), newFile: file };
    }

    try {
        let blob;
        if (isHeic) {
            // HEICは heic2any で変換（Exifは消える）
            blob = await heic2any({
                blob: file,
                toType: "image/jpeg",
                quality: 0.7
            });
        } else {
            // JPEG/PNGなどは Canvas で描き直して圧縮
            blob = await processViaCanvas(file, 0.7);
        }

        // ファイル名を「upload_タイムスタンプ.jpg」に完全固定（日本語・特殊文字対策）
        const newFile = new File([blob], `upload_${Date.now()}.jpg`, { type: "image/jpeg" });

        return {
            previewUrl: URL.createObjectURL(blob),
            newFile: newFile
        };
    } catch (err) {
        console.error("画像処理失敗:", err);
        return { previewUrl: URL.createObjectURL(file), newFile: file };
    }
};

window.handleHeicAndReplace = async function(file, inputElement, submitBtn) {
    if (!file) return null;

    let originalText = '';
    if (submitBtn) {
        submitBtn.disabled = true;
        originalText = submitBtn.innerText;
        submitBtn.innerText = '画像処理中...';
    }

    try {
        // ★ ここで新しい関数を呼ぶように変更
        const result = await window.convToProcessedImage(file);

        if (file !== result.newFile) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(result.newFile);
            inputElement.files = dataTransfer.files;
        }
        return result.previewUrl;
    } finally {
        if (submitBtn) {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = originalText;
            }
        }
    }
};
