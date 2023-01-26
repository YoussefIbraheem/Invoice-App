
        // var date = $('.fc-datepicker').datepicker({
        //     dateFormat: 'yy-mm-dd'
        // }).val();
 


      
        function myFunction() {
            var Amount_Commission = parseFloat(document.getElementById("Amount_Commission").value);
            var Discount = parseFloat(document.getElementById("Discount").value);
            var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value);
            var Value_VAT = parseFloat(document.getElementById("Value_VAT").value);
            var Amount_Commission2 = Amount_Commission - Discount;
            if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {
                alert('Please Insert Commission Amount');
            } else {
                var intResults = Amount_Commission2 * Rate_VAT / 100;
                var intResults2 = parseFloat(intResults + Amount_Commission2);
                sumq = parseFloat(intResults).toFixed(2);
                sumt = parseFloat(intResults2).toFixed(2);
                document.getElementById("Value_VAT").value = sumq;
                document.getElementById("Total").value = sumt;
            }
        }

$(document).ready(()=>{
    $("#Amount_Commission").keyup(function (e) { 
        myFunction()
    });
    $("#Discount").keyup(function (e) { 
        myFunction()
    });
    $("#Rate_VAT").change(function (e) { 
        myFunction()
    });
})
     

