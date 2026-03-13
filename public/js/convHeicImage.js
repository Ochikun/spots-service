window.handleHeicAndReplace = async function(file) {
    if (!file) return null;

    const fileName = file.name.toLowerCase();
    const isHeic = file.type === "" && fileName.endsWith(".heic");

    // HEIC以外ならそのままURLを生成して返す
    if (!isHeic) {
        return URL.createObjectURL(file);
    }

    try {
        // HEICの場合のみheic2anyで変換
        const blob = await heic2any({
            blob: file,
            toType: "image/jpeg",
            quality: 0.7
        });
        return URL.createObjectURL(blob);
    } catch (err) {
        console.error("プレビュー用の画像変換に失敗しました:", err);
        // 失敗した場合は元のファイルのURLを返す
        return URL.createObjectURL(file);
    }
};
