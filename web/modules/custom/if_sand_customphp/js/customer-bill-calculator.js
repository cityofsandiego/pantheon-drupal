jQuery('#customertype').change(function() {
  if(jQuery(this).val() == '1' || jQuery(this).val() == '2'){
    jQuery('.sewerservicechargeinput').show();
    jQuery('.sewerservicechargeinputdisabled').hide();
  } else {
    jQuery('.sewerservicechargeinput').hide();
    jQuery('.sewerservicechargeinputdisabled').show();
  }
});

/* AJAX form submission. */
jQuery('form#wbc').submit(function(e) {
  e.preventDefault();
  jQuery.ajax({
    type: 'POST',
    url: '/staging/public-utilities/customer-service/billing/bill-calculator-2023/calculate',
    data: jQuery('form#wbc').serializeArray(),
    success: function(response) {
      jQuery('#form-response').html(response);
      jQuery('html,body').animate({ scrollTop: jQuery('.node__content').offset().top });
    }
  });
});