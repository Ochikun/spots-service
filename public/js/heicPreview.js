
 document.addEventListener('DOMContentLoaded', function() {
    //画像プレビュー
    const imageInput = document.getElementById('image');
    const previewImage = document.getElementById('previewImage');

    //画像Heic拡張子をjpg変換
    imageInput.onchange = async () => {
        const url = await handleHeicImg(imageInput.files[0]);
        previewImage.src = url;
    };


    handleHeicImg = async function(heicFile) {
        if (!heicFile) return null;

        const fileName = heicFile.name.toLowerCase();
        const isHeic = fileName.endsWith(".heic");

        // HEIC以外ならそのままURLを生成して返す
        if (!isHeic) {
            return URL.createObjectURL(heicFile);
        }

        try {
            const blob = await heic2any({
                blob: heicFile,
                toType: "image/jpeg",
                quality: 0.7
            });
            return URL.createObjectURL(blob);
        } catch (err) {
            console.error("プレビュー用の画像変換に失敗しました:", err);
            return URL.createObjectURL(heicFile);
        }
    };
});
