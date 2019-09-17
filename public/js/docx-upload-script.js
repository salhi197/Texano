function clearFile() {
  $('#clear').click(function() {
    $("#myFile").val("");
  }); 
  $("#custom-text").val('')  
  $("#editor").html('')                 
  console.log('[cleaning the file ]'+$("#myFile").val())
}

// TODO: Document all functions 
function readFile(event) {
  var myFile = document.getElementById('myFile').files[0];
  //get uploaded file ...
  var file= window.URL.createObjectURL(myFile)
  //get file extension
  var ext = myFile.name.split('.').pop();
  console.log('[extension..]'+ext);
  //get filename and put it into the file name input 
  var filename = myFile.name;
  console.log('[Adding file name to input..]');
  $("#custom-text").val(filename)
  //if the file is a .docx , do this treatmant , put its contetn in the textarea 
  if(ext!='docx'){
      alert('the format should be .docx')
      clearFile()
      return 0;
  } 
  var loadFile=function(url,callback){
    JSZipUtils.getBinaryContent(url,callback);
  }
  loadFile(file,function(err,content){
    var doc=new Docxgen(content);
    text=doc.getFullText();
    var node = document.getElementById('editor');
    node.innerHTML = text;
    console.log(text);
  });          
  return 0;
}            

$('#storeForm').parsley();
            
            
            
            
            
//generate & download docx file 
function getFile() {
if ($("#editor").text()=='') {
 alert('[ no file selected ]')
 return 0;    
}    
const doc = new Document();
const paragraph = new Paragraph($("#editor").text());
doc.addParagraph(paragraph);
const packer = new Packer();
packer.toBlob(doc).then(blob => {
  console.log(blob);
  saveAs(blob, $('#custom-text').val()+".docx");
  console.log("Document created successfully");
});
}            



//auto saving function
var timer;
//server side vars ,
var saved_title = ''
var saved_text = ''

function AutoSave(){
    clearTimeout(timer);
    timer = setTimeout(function (event) {

    var titel = $('#custom-text').val();

    var  text_data= $('#editor').text();
    var  html_data= $('#editor').html();
    var  lastId= $('#lastId').val();
    

    
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "800",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };
console.log('[auto_saving ]')

//checking if titel & text_dat is not null 

if(titel == '' || text_data=='')    
{
console.log('[Data Empty ...]')
}else /*titel is not empty AND  text_data is not empty*/ {
    
    //if titel equels old values , AND data equals old value then there is no chnages .... 
    if(titel == saved_title && text_data == saved_text){
            console.log('[no changes ..]')
    }else/*titel not equels old value OR data nor equles old value which mean .. a change happend */{
          $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "POST",
              url:'/autosave',
              // serializes the form's elements.
              data: {titel:titel,html_data:html_data,text_data:text_data,lastId:lastId}, 
              success: function(data){
                  saved_title = data.server_title;
                  saved_text = data.server_text;
                  $('#lastId').val(data.server_id);   
                  toastr.success('Saved..');
                  $('#storeForm').attr('action','/text/'+data.server_id);
                  console.log($('#storeForm').attr('action')+'-'+saved_title+'- '+titel+'|'+saved_text+'-'+text_data);
              },
              error:function(xhr, status, error){
                  console.log(xhr.responseText); // show response from the php script.
              }
          });    
        
    }  
    
}

        
    }, 2000);
}





