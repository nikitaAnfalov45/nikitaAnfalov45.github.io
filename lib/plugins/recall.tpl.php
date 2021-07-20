<?php
global $shared_path;
?>
<style>
    #recall-btn {display: none;}
    .recall-animation {
        width: 90px;
        height: 90px;        
        text-align: center;
        position: fixed;
        margin: 0;
        padding: 10px;
        border-radius: 100%;
        border: solid 5px #fff;
        animation: play 2s ease infinite;
        -webkit-backface-visibility: hidden;
        -moz-backface-visibility: hidden;
        -ms-backface-visibility: hidden;
        backface-visibility: hidden;
        background-color: #fff;
        z-index: 99999;
        right: 1%;
        bottom: 100px;    
        -webkit-box-sizing: unset;
        -moz-box-sizing: unset;
        box-sizing: unset;           
    }
    .recall-animation img {
        width: 90px;
        height: 90px;
        border-radius: 100%;
        background-color: rgb(255, 162, 53);
        /*position: absolute;*/
        /*left: 10px;
        top: 10px;*/
        cursor: pointer;
        
    }
    @keyframes play {
        0% {transform: scale(1);}
        15% {box-shadow: 0 0 0 5px rgba(255, 162, 53, 0.4);}
        25% {box-shadow: 0 0 0 10px rgba(255, 162, 53, 0.4), 0 0 0 20px rgba(255, 162, 53, 0.2);}
        25% {box-shadow: 0 0 0 15px rgba(255, 162, 53, 0.4), 0 0 0 30px rgba(255, 162, 53, 0.2);}
    }
</style>

<script>
    $(function () {

        $("body").append('<div id="recall-btn"></div>');

        var callObj = '<div class="recall-animation"><img src="shared/plugins/icons/phone-white.png" alt="Перезвонить" /></div>'
        $('#recall-btn').html(callObj);


        $('#recall-btn').click(function () {
            var form_selector = $("#recall-form");
            PopupModal.modalShow(form_selector);            
            clearTimeout(PopupModal.timerId);
            $("#overlay-popup-recall").show();
            $("input[name=from_recall_button]", form_selector).val(1);
        });

        setTimeout(function () {
            $("#recall-btn").show();
        }, <?= $recall_timeout ?>);

        $(function () {


            $(document).on("click", ".recallmodal", function (event) {                
                if (event.target != this) {
                    return false;
                } else {
                    PopupModal.modalHide($(this).closest(".recallmodal"));                    
                }
            }).on("click", ".close-recall", function (event) {
                if (event.target != this) {
                    return false;
                } else {
                    PopupModal.modalHide($(this).closest(".recallmodal"));
                    PopupModal.panelQuickOrderShow();
                }
            }).on("keydown", function (key) {
                if (key.keyCode == 27) {
                    PopupModal.modalHide($(".recallmodal:visible:last"));
                }
            }).on("click", ".recallmodal > *", function (event) {
                event.stopPropagation();
                return true;
            });
        });
    });
</script>
