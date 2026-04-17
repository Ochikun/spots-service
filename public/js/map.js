document.addEventListener("DOMContentLoaded", () => {


    // map初期化 表示
    const map = L.map('map');
    L.tileLayer('https://tile.openstreetmap.jp/{z}/{x}/{y}.png', {
        attribution: "&copy; <a href='https://www.openstreetmap.org/copyright'>OpenStreetMap</a> contributors"
    }).addTo(map);

    //住所検索機能
    const option = {
        collapsed: false, //コントローラーの折り畳み
        placeholder: '場所を入力してください', //プレースホルダーテキスト
        errorMessage: '見つかりませんでした',
        showUniqueResult: false,
    }
    L.Control.geocoder(option).addTo(map);

    // モーダルフォーム初期化処理
    map.on("click", function(e){//mapの緯度経度情報が入る
        //エラー表示削除
        document.querySelectorAll('.error-message').forEach(errorElement  => errorElement.remove());
        //formをリセット
        document.getElementById('spotForm').reset();
        document.querySelector('textarea[name="body"]').value = '';
        document.getElementById('previewImage').src = '/storage/photos/noprofile.jpg';
        //ガイド文削除
        let guide = document.getElementById('guide-message');
        if(guide){guide.remove();}

        openModal(e.latlng.lat,e.latlng.lng);
    });


    //地図に登録画像を描画
    spots.forEach(spot => {
        const categoryColor = spot.category?.color || '#ffffff';
        const url = spotShowUrl.replace(':id', spot.id);
        const icon = L.divIcon({
            html: `
            <div style="position: relative; width: 60px; height: 60px;">
                <a href="${url}" onclick="event.stopPropagation()">
                    <div style="
                        width: 60px;
                        height: 60px;
                        border-radius: 50%;
                        border: 3px solid ${categoryColor};
                        overflow: hidden;
                        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
                        background-color: white;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    ">
                        ${spot.image
                            ? `<img src="${spot.S3Url}" style="width: 100%; height: 100%; object-fit: cover;">`
                            : `<svg style="width: 32px; height: 32px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>`
                        }
                    </div>
                    <div style="
                        position: absolute;
                        bottom: -8px;
                        left: 50%;
                        transform: translateX(-50%);
                        width: 0;
                        height: 0;
                        border-left: 10px solid transparent;
                        border-right: 10px solid transparent;
                        border-top: 12px solid ${categoryColor};
                        filter: drop-shadow(0 2px 2px rgba(0,0,0,0.3));
                    "></div>
                </a>
            </div>
            `,
            className: "",
            iconSize: [60, 72],
            iconAnchor: [30, 72]
            });
        L.marker([spot.lat, spot.lng], { icon }).addTo(map);
    });

    //ズーム距離最適化処理
    //spots.show経由の場合は緯度経度を拡大して表示
    //データが一件のみの時に拡大表示されないようにする
    const params = new URLSearchParams(window.location.search);
    const hasSpotId = params.has('spot_id');
    if (hasSpotId && spots.length === 1) {
        const spot = spots[0];
        map.setView([spot.lat, spot.lng], 16);
    } else {
        map.setView([37.681236, 139.767125], 6);
    }


    //位置情報取得、地図移動
    let locMarker = null;
    document.getElementById('setMyLocation')
        .addEventListener('click',function(){

        if (!navigator.geolocation) {
            alert("お使いのブラウザは位置情報に対応していません。");
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                if (locMarker) {
                    map.removeLayer(locMarker);
                }
                locMarker = L.marker([lat, lng]).addTo(map);
                map.setView([lat, lng], 15);
            },

            function(e) {
                alert("位置情報の取得に失敗しました。設定を確認してください。");
            }

        );
    });

});
