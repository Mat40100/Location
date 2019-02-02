$(document).ready(function(){
    slotDate = $('#course_slotTaken_slotDate');
    slot = $('#course_slotTaken_slot');
    slotRoom = $('#course_slotTaken_room');
    maxNumber = $('#course_maximumCustomerNumber');

    slotDate.parent().hide();
    slot.parent().hide();
    maxNumber.parent().hide();

    if (slotRoom.val() != null) {
        slotDate.parent().show();
        slot.parent().show();
    }

    slotRoom.change(function(){
        maxNumber.prop('disabled', true);
            maxNumber.val('');
        maxCustomerRequest();


        if (slotDate.val() !== '') {
            slotRoom.prop('disabled', true);
            slotRequest();
        }else slotDate.parent().show();

    });

    slotDate.change(function(){
        slotDate.prop('disabled', true);
        slotRequest();
    });
});


function slotRequest() {
    var date = slotDate.val();
    var room = slotRoom.val();

    $.ajax({
        url : '/ajax/course/date/'+ date + "/" + room,
        type : 'GET',
        dataType : 'html',
        success : function(code_html, statut){
            $(code_html).replaceAll('#course_slotTaken_slot');
            var slot = $('#course_slotTaken_slot');

            slotRoom.prop('disabled', false);
            slotDate.prop('disabled', false);
            slot.parent().show();
        }
    });
}

function maxCustomerRequest() {
    var room = slotRoom.val();

    $.ajax({
        url : '/ajax/room/'+ room + "/max",
        type : 'GET',
        dataType: 'json',
        success : function(json){
            maxNumber.attr('max', json.data);

            maxNumber.prop('disabled', false);
            maxNumber.parent().show();
        }
    });
}
