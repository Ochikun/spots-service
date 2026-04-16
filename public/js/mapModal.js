document.addEventListener("DOMContentLoaded", () => {

    const spotModal = document.getElementById("spotModal");
    const modalLat = document.getElementById("modal-lat");
    const modalLng = document.getElementById("modal-lng");
    const closeModal = document.getElementById("closeModal");

    //モーダル機能　
    window.openModal = function(lat = null, lng = null){
        spotModal.classList.remove("hidden");
        if((lat!==null) && (lng!==null)){
            modalLat.value = lat;
            modalLng.value = lng;
        }
    }

    // モーダルを閉じる機能
    closeModal.addEventListener("click",() => {
        spotModal.classList.add("hidden");
    });
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            spotModal.classList.add("hidden");
        }
    });
    spotModal.addEventListener("click", (e) => {
        if (e.target === spotModal) {
            spotModal.classList.add("hidden");
        }
    });

    //モバイル用フィルター画面開閉メニュー
    const toggle = document.getElementById('filterToggle');
    const body = document.getElementById('filterBody');
    const arrow = document.getElementById('filterArrow');

    toggle.addEventListener('click', function() {
        body.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    });
});
