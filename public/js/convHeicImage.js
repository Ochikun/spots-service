
window.convHeicToImage = async function(file)
{
  if(!file || !(file.type === "" && file.name.toLowerCase().endsWith(".heic")))
  {
    return {
      previewUrl: URL.createObjectURL(file),
      newFile: file
    };
  }

  try{
    const blob = await heic2any({
      blob:file,
      toType: "image/jpeg",
      quality: 0.7
    });
    const newFile = new File([blob], file.name.replace(/\.[^/.]+$/, "") + ".jpg", {
      type: "image/jpeg",
    });

    return {
      previewUrl: URL.createObjectURL(blob),
      newFile: newFile
    };
  }catch(err){
    console.error("画像の変換に失敗しました",err);
    return{
      //.heicファイルをそのまま返してlaravelのrequestで弾く
      previewUrl: URL.createObjectURL(file),
      newFile: file
    };
  }
};

window.handleHeicAndReplace = async function(file, inputElement){
  if (!file) return null;
  //{previewUrl:URL, newFile:file}が返る
  const result = await window.convHeicToImage(file);

  if(file !== result.newFile){
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(result.newFile);
      inputElement.files = dataTransfer.files;

      console.log(inputElement.files[0].name);//消す
  }
  return result.previewUrl;
}
