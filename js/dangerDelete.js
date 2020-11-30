document.addEventListener("DOMContentLoaded",function(){
  
    $('.js-btn-tooltip').tooltip();
    $('.js-btn-tooltip--custom').tooltip({
      customClass: 'tooltip-custom'
    });
    $('.js-btn-tooltip--custom-alt').tooltip({
      customClass: 'tooltip-custom-alt'
    });
});