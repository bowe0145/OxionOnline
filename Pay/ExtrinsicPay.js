$(function() {

	/*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		*	ExtrinsicPay.com                                        *
		*	(c) 2015 Extrinsic Studio, LLC - All Rights Reserved    *
		*	http://extrinsicpay.com                                 *
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

		startEPPayment:
		Call this function when you are ready to direct the user to the payment page
		
		ep_key    : Application Key from your ExtrinsicPay.com Application panel
		ep_paytype: Payment Type. 0 = Credit/Debit/Gift Card, 1 = Paysafecard, 2 = PayPal
		ep_price  : Dollar amount, in USD, to charge the user
		ep_user   : ID number of the user
	*/

	startEPPayment = function(ep_key, ep_paytype, ep_price, ep_user) {
		$('html').append('<div style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.8);z-index:3000;width:100%;height:100%;"/><div style="margin:0 auto;top:50%;left:45%;position:absolute;z-index:3001;color:white;"><img src="https://extrinsicpay.com/Theme/images/l2.gif"></div>');
        $('body').append(
            $('<form />', { action: 'https://ExtrinsicPay.com', method: 'POST', id: 'ep_payform' }).append(
                $('<input />', { id: 'dopay', name: 'dopay', value: 'dopay', type: 'hidden' }),
                $('<input />', { id: 'key', name: 'key', value: ep_key, type: 'hidden' }),
                $('<input />', { id: 'ptype', name: 'ptype', value: ep_paytype, type: 'hidden' }),
                $('<input />', { id: 'price', name: 'price', value: ep_price, type: 'hidden' }),
				$('<input />', { id: 'user', name: 'user', value: ep_user, type: 'hidden' })
            )
        );
		$('#ep_payform').submit();
	}
});
