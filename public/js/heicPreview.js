window.handleHeicImg = async function(heicFile) {
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
