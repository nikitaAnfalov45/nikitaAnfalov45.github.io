<script>
    
   $(function(){ 

    PopupModal.initModal(<?= $popup_timeout ?>);
    
    $(function () {


            $(document).on("click", ".close-popup-recall", function (event) {                
                if (event.target != this) {
                    return false;
                } else {
                    PopupModal.modalHide($(this).closest(".recallmodal"));
                    PopupModal.panelQuickOrderShow();
                }
            });
        });
        
    });
</script>

