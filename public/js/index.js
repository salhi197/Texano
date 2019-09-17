 var $j = jQuery.noConflict();
    /*
window.addEventListener('beforeunload', function (e) {
  // Cancel the event
  e.preventDefault();
  // Chrome requires returnValue to be set
  e.returnValue = '';

});

*/function consoleLogs(response) {
  if(env=='local'){
    console.log(response)
  }

}
function readPdfFile(myfile){

    //Read the file using file reader
    var fileReader = new FileReader();
    fileReader.onload = function() {
        //Turn array buffer into typed array
        var typedarray = new Uint8Array(this.result);
        //calling function to read from pdf file
        $j('#editor').css({'display':'none' });
        $j('.loading').css({'display':'block'});        
        getText(typedarray).then(function(text) {

                /*Selected pdf file content is in the variable text. */
                $j("#editor").html(text);
                // $j('#editor').css({'display':'block' });
                $j('.loading').css({'display':'none'});                
                  AutoSave() 
            }, function(reason) //Execute only when there is some error while reading pdf file
            {
                alert('Seems this file is broken, please upload another file');
                console.error(reason);
            });
        //getText() function definition. This is the pdf reader function.
        function getText(typedarray) {
            //PDFJS should be able to read this typedarray content
            var pdf = PDFJS.getDocument(typedarray);
            return pdf.then(function(pdf) {
                // get all pages text
                var maxPages = pdf.pdfInfo.numPages;
                var countPromises = [];
                // collecting all page promises
                for (var j = 1; j <= maxPages; j++) {
                    var page = pdf.getPage(j);
                    var txt = "";
                    countPromises.push(page.then(function(page) {
                        // add page promise
                        var textContent = page.getTextContent();
                        return textContent.then(function(text) {
                            // return content promise
                            return text.items.map(function(s) {
                                return s.str;
                            }).join(''); // value page text
                        });
                    }));
                }

                // Wait for all pages and join text
                return Promise.all(countPromises).then(function(texts) {
                    return texts.join('');
                });
            });
        }
    };
    //Read the file as ArrayBuffer
    fileReader.readAsArrayBuffer(myfile);

}

function readDocxFile(file) {
    var loadFile=function(url,callback){
      JSZipUtils.getBinaryContent(url,callback);
    }
    loadFile(file,function(err,content){
      var doc=new Docxgen(content);
      consoleLogs(doc)
      text=doc.getFullText();
      var node = document.getElementById('editor');
      node.innerHTML = text;
    });
  
}


function clearFile() {
  $j('#clear').click(function() {
    $j("#myFile").val("");
  }); 
  $j("#custom-text").val('')  
  $j("#editor").html('')
  consoleLogs('[cleaning the file ]'+$j("#myFile").val())

}



// TODO: Document all functions 
var htmlTEXT ; 

function readFile(event) {


  require("docx2html")(document.getElementById('myFile').files[0])
  .then(function(converted){  
      document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerHTML =converted.toString() ; 
      localStorage.setItem("html_code", converted.toString());
  }).catch(function(e) {
    alert("this file contain some unsupported elements , you may have find missing elements !");  
    document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerHTML =document.getElementById('A').innerHTML ; 
    localStorage.setItem("html_code", document.getElementById('A').innerHTML);    
  }).then(function (e) {
  })

  var myFile = document.getElementById('myFile').files[0];
  ValidateSize(myFile);
  countPages(myFile);
  //get uploaded file ...
  consoleLogs(myFile)
  var file= window.URL.createObjectURL(myFile)
  consoleLogs(file)

  //get file extension
  var extension = myFile.name.split('.').pop();
  consoleLogs('[extension..]'+extension)

  //get filename and put it into the file name input 
  var filename = myFile.name;
  consoleLogs('[Adding file name to input ]')
  x= filename.split(".");
  filenameWithoutExtention = x[0];  
  document.getElementById("custom-text").value = filenameWithoutExtention
  //if the file is a .docx , do this treatmant , put its contetn in the textarea 




if (extension=='docx') {
  readDocxFile(file)    
  AutoSave()          
}
else if (extension=='pdf') {
  readPdfFile(myFile)             
}
else{
  alert('only docx and pdf file are supported ')
}
  return 0;
}            

//$j('#storeForm').parsley();
function decodeHTMLEntities(text) {
  var entities = [
      ['amp', '&'],
      ['apos', '\''],
      ['#x27', '\''],
      ['#x2F', '/'],
      ['#39', '\''],
      ['#47', '/'],
      ['lt', '<'],
      ['gt', '>'],
      ['nbsp', ' '],
      ['&quot;', '"']
  ];

  for (var i = 0, max = entities.length; i < max; ++i) 
      text = text.replace(new RegExp('&'+entities[i][0]+';', 'g'), entities[i][1]);

  return text;
}
          
            
            
            
            
//generate & download docx file 

function getFile() {
convertImagesToBase64()
contentDocument=document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerHTML;
contentDocument=contentDocument.substr(contentDocument.search('</style>')+8,contentDocument.length)
//contentDocument=decodeHTMLEntities(contentDocument)
var converted = htmlDocx.asBlob(contentDocument);

saveAs(converted, 'test.docx');

}            
function convertImagesToBase64  () {

  var regularImages =  document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].querySelectorAll("img");
  consoleLogs(regularImages)
  var canvas = document.createElement('canvas');
  var ctx = canvas.getContext('2d');
  [].forEach.call(regularImages, function (imgElement) {
  // preparing canvas for drawing
  ctx.clearRect(0, 0, canvas.width, canvas.height);
// change here start
  canvas.width = imgElement.naturalWidth;
  canvas.height = imgElement.naturalHeight;
//change here end
  ctx.drawImage(imgElement, 0, 0);
  // by default toDataURL() produces png image, but you can also export to jpeg
  // checkout function's documentation for more details
  var dataURL = canvas.toDataURL();
  imgElement.setAttribute('src', dataURL);
  })
  canvas.remove();
}


//auto saving function
var timer;
//server side vars ,
var saved_title = ''
var saved_text = ''

function sendAjaxRequest(titel,html_data,text_data,lastId) {
          $j.ajax({
              headers: {
              'X-CSRF-TOKEN': $j('meta[name="csrf-token"]').attr('content')
              },
              type: "POST",
              url:'/autosave',
              // serializes the form's elements.
              data: {titel:titel,html_data:html_data,text_data:text_data,lastId:lastId}, 
              success: function(data){
                  saved_title = data.server_title;
                  saved_text = data.server_text;
                  $j('#lastId').val(data.server_id);   
                  toastr.success('saved');
                  $j('#storeForm').attr('action','/text/'+data.server_id);
                  consoleLogs($j('#storeForm').attr('action')+'-'+saved_title+'- '+titel+'|'+saved_text+'-'+text_data);                  
              },
              error:function(xhr, status, error){
                  consoleLogs(xhr.responseText)
                  // show response from the php script.
              }
          });    
}


function AutoSave(){
    clearTimeout(timer);
    timer = setTimeout(function (event) {
    var titel = $j('#custom-text').val();
    var  text_data= document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerText;//$j('#editor').text();
    var  html_data= document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerHTML;//$j('#editor').html();
    var  lastId= $j('#lastId').val();      
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
if(titel == '' || text_data=='')    
{
consoleLogs('[Data Empty ...]')  
}else {
    if(titel == saved_title && text_data == saved_text){
      consoleLogs('[no changes ..]')  
    }else{
      sendAjaxRequest(titel,html_data,text_data,lastId);          
    }  
}        
    }, 500);
}


function changeFile2X(what, node) {

  // initialize values if first call
  node = node || document.body;
  var nodeList = node.childNodes;

  // traverse all the children nodes
  for (var x = 0; x < nodeList.length; x++) {

      // text node, search directly
      if (nodeList[x].nodeType == 3) {

          //var regex = new RegExp('\\b' + what + '\\b');
          // if it contains the text that you are looking for, proceed with the replacement
          if (nodeList[x].textContent.indexOf(what) >= 0) {

              // your code (mostly :P)
              var replacement = "X" ; //'<span id="'+ID+'" style="background-color:#f0da1e">'+what+'</span>';
              
              //var regex = new RegExp('\\b' + what + '\\b');
              
              var textBlock = nodeList[x].textContent;
              var searchIndex = nodeList[x].textContent.indexOf(what);
              while(searchIndex >= 0)
              {
                  ++counter;
                  
                  replacement = "X" //'<span id="'+ID+'" style="background-color:#f0da1e">'+what+'</span>';         
                  textBlock = textBlock.substring(0, searchIndex) + replacement + textBlock.substring(searchIndex + what.length, textBlock.length);
                  searchIndex = textBlock.toLowerCase().indexOf(what.toLowerCase(), (searchIndex + replacement.length));
              }

              // create a new element with the replacement text
              var replacementNode = document.createElement("span");
              replacementNode.innerHTML = textBlock;

              // replace the old node with the new one
              var parentN = nodeList[x].parentNode;
              parentN.replaceChild(replacementNode, parentN.childNodes[x]);

          }
      } else {
          // element node --> search in its children nodes
          highlightText(what,nodeList[x]);
      }
  }
}










/////////////////////////////////////////

function changeHTML2X(htmlCode) {

  words = localStorage.getItem("words").split(',').slice(1)

  var newHTML=htmlCode;

  var lastIndex,i=0;

  while(i<words.length){
      wordIndex = words[i]
      //lastIndex = words.slice(0,i).indexOf(wordIndex);
      lastIndex= newHTML.search(wordIndex)
    if(lastIndex!=-1){
      newHTML= newHTML.substr(0,lastIndex) + "X" + newHTML.substr(lastIndex+words[i].length);
    }
    i++;

      }
      return newHTML;
}



function insertHTMLinEditPage(html){
  document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerHTML=html
 
}


function ValidateSize(file) {
        var FileSize = file.size / 1024 / 1024; // in MB
        console.log('File size  MB = '+FileSize+' MB');
        if (FileSize > 3) {
            console.log('File size exceeds 2 MB = '+FileSize);
           // $(file).val(''); //for clearing with Jquery
        } else {

        }
    }
function countPages(my_File) {
    console.log(my_File)
  
}