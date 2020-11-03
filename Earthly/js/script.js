(function () {

    "use strict";

    document.addEventListener("DOMContentLoaded", initialiser);

    let loading = $("#loading");

    function initialiser() {

        
        
        let regions = document.getElementsByClassName("regions");
        for (let region of regions) {
            region.addEventListener(hover, survol);
        }


        let carte = $(".body");

        window.setInterval(load , 3000);
    }

    function survol(evt) {
        let regionsurvol = this;
        //regionsurvol.style.
        //nathan aide moi

    }

    function load(evt) {
        loading.css("display", "none");
    }

}());
