function addBook() {
    if($("#book_form").valid()){
        var bookName = document.getElementById('book_name').value;
        var authorName = document.getElementById('author_name').value;
        var language = document.getElementById('language').value;
        var category = document.getElementById('category').value;
        var rate = document.getElementById('rate').value;
        var oldNumber = document.getElementById('old_number').value;
        var isMultiple;
        if(document.getElementById('is_multicopy_yes').checked){
          isMultiple = document.getElementById('is_multicopy_yes').value;
        } else if (document.getElementById('is_multicopy_no').checked){
          isMultiple = document.getElementById('is_multicopy_no').value;
        }
        var data = "bookName=" + bookName + "&authorName=" + authorName + "&language=" + language + "&category=" + category + "&rate=" + rate + "&oldNumber=" + oldNumber + "&isMultiple=" + isMultiple + "&action=add_book"; 

        $.ajax({
            url: "services/book_services.php",
            type: "POST",
            data:  data,
            dataType: 'json',
            success: function(result){
                $('#addbook_modal').hide();
                if(result.infocode == 'INSERTSUCCESS'){
                    bootbox.alert(result.message, function(){
                        location.reload();
                    });
                } else {
                    bootbox.alert(result.message);
                }
            },
            error: function(result){
                bootbox.alert(result.message);
            }           
          });
    }
}

function viewBook(bookId, language){
    var data = "bookId=" + bookId + "&language=" + language +"&action=get_book_details";
    $.ajax({
        url: "services/book_services.php",
        type: "POST",
        data:  data,
        dataType: 'json',
        success: function(result){
            $('#edit_book_name').val(result.book_name);
            $('#edit_author_name').val(result.author_name);
            $('#edit_rate').val(result.rate);
            $('#edit_old_number').val(result.old_number);
            if(result.is_multiple == 'yes'){
            	$('#edit_is_multicopy_yes').attr('checked','');
            } else if(result.is_multiple == 'no'){
            	$('#edit_is_multicopy_no').attr('checked','');
            }
            if(language == 'tamil'){
            	$('#edit_language').val('tamil');
            } else if(language == 'english'){
            	$('#edit_language').val('english');
            }
            if(result.category == 'new'){
            	$('#edit_category').val('new');
            } else if(result.category == 'old'){
            	$('#edit_category').val('old');
            }
            $('#edit_book_id').val(bookId);
            $('#editbook_modal').modal('show');
        }         
    });
}

function searchBook(){
    var bookName = $('#search_book_name').val();
    var data = "bookName=" + bookName + "&action=search_book";
    $.ajax({
      url: "services/book_services.php",
      type: "POST",
      data:  data,
      dataType: 'html',
      success: function(result){
          $('#books_table_title').html("Search List");
          $('#books_table').html(result);
      }         
    });
}

function updateBook(){
    if($("#edit_book_form").valid()){
        var bookId = document.getElementById('edit_book_id').value;
        var bookName = document.getElementById('edit_book_name').value;
        var authorName = document.getElementById('edit_author_name').value;
        var language = document.getElementById('edit_language').value;
        var category = document.getElementById('edit_category').value;
        var rate = document.getElementById('edit_rate').value;
        var oldNumber = document.getElementById('edit_old_number').value;
        var isMultiple;
        if(document.getElementById('edit_is_multicopy_yes').checked){
          isMultiple = document.getElementById('edit_is_multicopy_yes').value;
        } else if (document.getElementById('edit_is_multicopy_no').checked){
          isMultiple = document.getElementById('edit_is_multicopy_no').value;
        }
        var data = "bookId=" + bookId + "&bookName=" + bookName + "&authorName=" + authorName + "&language=" + language + "&category=" + category + "&rate=" + rate + "&oldNumber=" + oldNumber + "&isMultiple=" + isMultiple + "&action=update_book"; 

        $.ajax({
            url: "services/book_services.php",
            type: "POST",
            data:  data,
            dataType: 'json',
            success: function(result){
                $('#editbook_modal').hide();
                if(result.infocode == 'UPDATESUCCESS'){
                    bootbox.alert(result.message, function(){
                        location.reload();
                    });
                } else {
                    bootbox.alert(result.message);
                }
            },
            error: function(result){
                bootbox.alert(result.message);
            }           
          });
    }
}

function deleteBook(bookId, language){
    bootbox.confirm('Are you sure you want to delete this book?',function(result){
        if(result){
            var data = "bookId=" + bookId + "&language=" + language +"&action=delete_book";
            $.ajax({
                url: "services/book_services.php",
                type: "POST",
                data:  data,
                dataType: 'json',
                success: function(result){
                    if(result.infocode == 'DELETESUCCESS'){
                        bootbox.alert(result.message, function(){
                            location.reload();
                        });
                    } else {
                        bootbox.alert(result.message);
                    }
                }         
            });
        }
    });
}