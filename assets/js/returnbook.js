g_booklist = new Array;

function member_search_book(){
    //$("#loader").show();  
    var searchField = $('#search_member').val();
    if(searchField.length>=1){
        $.ajax({
            type: "POST",
            url: "services/returnbook_services.php", // 
            data: "searchField="+searchField+"&action=search_member_book", 
            success: function(result){
                result = JSON.parse(result);
                if(result.infocode == 'SEARCHED'){
                    display_booklist(result.data, result.member_data);
                }else if(result.infocode=='NODATAFOUND'){
                    $('#autoselect_member').html("No books lent for this member").fadeIn(100).fadeOut(5000);
                    //$("#autoselect_member").removeClass('container');
                } 
                //$("#loader").hide();        
            }
        });
    } 
}

function display_booklist (g_selectedbooks, member_data) {
    var dp ='';total_amount = 0;g_booklist.length=0;
    template = '<tr><td>[bookdetail]</td><td>[lendingrate]</td><td>[lendingdate]</td><td>[duedate]</td><td>[returndate]</td><td>[penaltyperday]</td><td>[totalpenalty]</td><td>[action]</td>[bookkey] [booklang_hidden] [bookid_hidden] [bookcat_hidden] [duedate_hidden] [penaltydays_hidden] [lendingrate_hidden] [lendingdate_hidden] [bookrate_hidden] [remarks_hidden]</tr>';
    for(c=0;c<g_selectedbooks.length;c++){
        key = g_selectedbooks[c].lend_booklist_id;
        g_booklist.push(key);
        returndate = returnModDate(0);
        //duedate = (g_selectedbooks[c].book_language == 'tamil')?returnModDate(5):returnModDate(7);
        dp += template.replace('[bookdetail]',g_selectedbooks[c].book_id+' '+g_selectedbooks[c].book_name+ '<br> '+g_selectedbooks[c].author_name+ '<br> '+((g_selectedbooks[c].remarks == null)?'':g_selectedbooks[c].remarks))
                        .replace('[lendingrate]',g_selectedbooks[c].lending_rate)
                        .replace('[lendingdate]',g_selectedbooks[c].lending_date)
                        .replace('[duedate]',g_selectedbooks[c].due_date)
                        .replace('[returndate]','<input type="text" class="datepick" value="'+returndate+'" id="returndate_'+key+'" name="returndate_'+key+'" style="width:150px" onchange="calc_datediff(\'single\','+key+')">')
                        .replace('[penaltyperday]','<input type="text" value="'+key+'" id="penaltyperday_'+key+'" name="penaltyperday_'+key+'" style="width:150px">')
                        .replace('[totalpenalty]','<input type="text" value="'+key+'" id="totalpenalty_'+key+'" name="totalpenalty_'+key+'" style="width:150px">')
                        .replace('[action]','<input type="checkbox" name="check_return[]" id="check_return_'+key+'" value="'+key+'" checked="checked" onchange="calculate_penalty();">')
                        .replace('[bookkey]','<input type="hidden" name="book_key[]" value="'+key+'"/>')
                        .replace('[bookid_hidden]','<input type="hidden" name="bookid_'+key+'" id="bookid_'+key+'" value="'+g_selectedbooks[c].book_id+'"/>')
                        .replace('[booklang_hidden]','<input type="hidden" name="booklang_'+key+'" id="booklang_'+key+'" value="'+g_selectedbooks[c].book_language+'"/>')
                        .replace('[bookcat_hidden]','<input type="hidden" name="bookcat_'+key+'" id="bookcat_'+key+'" value="'+g_selectedbooks[c].book_category+'"/>')
                        .replace('[duedate_hidden]','<input type="hidden" name="duedate_'+key+'" id="duedate_'+key+'" value="'+g_selectedbooks[c].due_date+'"/>')
                        .replace('[penaltydays_hidden]','<input type="hidden" name="penaltydays_'+key+'" id="penaltydays_'+key+'" value=""/>')
                        .replace('[lendingrate_hidden]','<input type="hidden" value="'+g_selectedbooks[c].lending_rate+'" id="lendingrate_'+key+'" name="lendingrate_'+key+'">')
                        .replace('[lendingdate_hidden]','<input type="hidden" value="'+g_selectedbooks[c].lending_date+'" id="lendingdate_'+key+'" name="lendingdate_'+key+'">')
                        .replace('[bookrate_hidden]','<input type="hidden" value="'+g_selectedbooks[c].book_rate+'" id="bookrate_'+key+'" name="bookrate_'+key+'">')
                        .replace('[remarks_hidden]','<input type="hidden" value="'+g_selectedbooks[c].remarks+'" id="remarks_'+key+'" name="remarks_'+key+'">')
    }
    $('#tbody_selectedbooks').html(dp);
    //$('#total_amount').val(total_amount);
    $('.datepick').datepicker({
        todayHighlight: 1,
        autoclose: 1,
        format: 'yyyy-mm-dd',
    });
    calc_datediff('all',0);
    memid_display = String("0000" + member_data.member_id).slice(-4);
    $('#member_name_span').html('Selected member : '+ memid_display + ' ' + member_data.member_name + ' ' + member_data.phone_number);
    $('#member_credit').val(member_data.member_credit);
    $('#selected_member_id').val(member_data.member_id)
}

function returnModDate(days){
    var someDate = new Date();
    var numberOfDaysToAdd = days;
    if(days){
        someDate.setDate(someDate.getDate() + days);
    }

    var dd = someDate.getDate();
    var mm = someDate.getMonth() + 1;
    var y = someDate.getFullYear();
    if(dd < 10) dd = '0'+dd;
    if(mm < 10) mm = '0'+mm;
    var someFormattedDate = y + '-'+ mm + '-'+ dd; 

    return someFormattedDate;
}

function calc_datediff(mode, key){
    
    if(mode == 'single'){
        return_date = moment($('#returndate_'+key).val());
        due_date = moment($('#duedate_'+key).val());
        penalty_days = return_date.diff(due_date, 'days');
        $('#penaltydays_'+key).val(penalty_days);
    }else{
        for(i in g_booklist){
            key = g_booklist[i];
            return_date = moment($('#returndate_'+key).val());
            due_date = moment($('#duedate_'+key).val());
            penalty_days = return_date.diff(due_date, 'days');
            $('#penaltydays_'+key).val(penalty_days);
        }
    }
    calculate_penalty();
}

function calculate_penalty(){
    grand_total = 0;
    for(i in g_booklist){
        key = g_booklist[i];
        if($('#check_return_'+key).is(':checked')){
            penalty_days = parseInt($('#penaltydays_'+key).val());
            lending_rate = $('#lendingrate_'+key).val();
            bookcat = $('#bookcat_'+key).val();
            booklang = $('#booklang_'+key).val();
            noofdays = g_config_lendingdays[booklang][bookcat];
            /*if($('#bookcat_'+key).val() == 'old' || $('#booklang_'+key).val() == 'english'){
                noofdays = 7;
            }else{
                noofdays = 5;
            }*/
            if(penalty_days > 0){
                penaltyperday = Math.round(parseInt(lending_rate) / parseInt(noofdays));
                $('#penaltyperday_'+key).val(penaltyperday);
                totalpenalty = penaltyperday * penalty_days;
                $('#totalpenalty_'+key).val(totalpenalty);
                grand_total = parseInt(grand_total) + totalpenalty;
            }else{
                $('#penaltyperday_'+key).val(0);
                $('#totalpenalty_'+key).val(0);
            }
        }
    }
    $('#total_amount').val(grand_total);
    calcBalance();
}

function calcBalance(){
    member_credit = $('#member_credit').val().trim();
    advance = $('#advance_amount').val().trim();
    total_amount = $('#total_amount').val().trim();
    balance = 0;
    if(!isNaN(advance)){
        balance = parseInt(member_credit) + parseInt(advance) - parseInt(total_amount);
        $('#balance_amount').val(balance);
    }
}

function return_book_process(){
    var data = $('#returnbook_form').serialize();
    $.ajax({
        type: "POST",
        url: "services/returnbook_services.php", // 
        data: data, 
        success: function(result){
            result = JSON.parse(result);
            if(result.infocode == 'RETURNBOOKSUCCESS' || result.infocode == 'RETURNBOOKPARTIAL'){
                bootbox.alert(result.message, function(){
                    $('#returnbook_form')[0].reset(); location.reload();
                });
            }else {
                bootbox.alert(result.message);
            } 
        }
    });
}