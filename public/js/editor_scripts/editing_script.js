var $j = jQuery.noConflict();

String.prototype.searchWord = function (argument){ 
var  res = this.split(" ");
return  output = res.indexOf(argument);

}
$j(document).ready(function () {
    clearLocalStorage()
    let tableHtml = "<table class='table table-bordered'>";
    let editorText = document.getElementById('editor').innerText;
    let editor = document.getElementById('editor');
    let responseData='';
    new Medium({
        element: document.getElementById('editor'),
        // placeholder: "Type a text here",
        autofocus: true,
        autoHR: false,
        mode: Medium.richMode,
        keyContext: null,
    });
    $j("button").click(function () {
        if (document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerText.length==0) {
            alert('please add a file or type a text')
            return 0;
        }
        const which = $j(this).data("which");
            let dataJSON = {
            "document":{
            "type":"PLAIN_TEXT",
            "content":document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerText,
            },
            "features":{
            "extractSyntax":true,
            "extractEntities":true,
            "extractDocumentSentiment":true
            },
            "encodingType":"UTF8"                
            }    

        if (which == "findData") {
            let elementChecked = pushChecks();
            tokenResponse(dataJSON).then(result => {
                //consoleLogs(result)
                //localStorage.setItem('x',result.response)
                if (elementChecked) {
                    if(result.code==1){
                        detectEntities(result.response, false)
                    }else{
                        alert('you are out of limitation');
                    }
                    
                }
                else {
                    alert('Please select a category to anonymize');
                }
                // document.getElementById("editorContentHTML").value = document.getElementById("editor").innerHTML;
            });
        }
        else if (which == "anoynmizeData") {
            let elementChecked = pushChecks();
            tokenResponse(dataJSON).then(result => {
                if (elementChecked) {
                    if(result.code==1){
                        detectEntities(result.response, true)
                    }else{
                        alert('you are out of limitation');
                    }
                }
                else {
                    alert('Please select a category to anonymize');
                }
                // document.getElementById("editorContentHTML").value = document.getElementById("editor").innerHTML;
            });
        } // end AnoPerNames
    }); // end button click


    function tokenResponse(editorText) {
        var d=JSON.stringify(editorText);
        return new Promise(
            function (resolve, reject) {
                let result = '';
                $j.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $j('meta[name="csrf-token"]').attr('content')
                    },          
                    type: "POST",
//                    dataType: 'json',
 //                   contentType: 'application/json',
                    beforeSend: function(){  
                        $j('.loading').css({'display':'block'});
                        $j('#cke_editor1').css({'display':'none'});

                    },
                    url:'/classify',
//                      url:"https://language.googleapis.com/v1beta2/documents:annotateText?key=AIzaSyDActRxdx5VFlcSTd9Vl84ciKm3UFCUa7w",  
//                    url: "http://corenlp.run/?properties=%7B%22annotators%22%3A%20%22tokenize%2Cssplit%2Cner%22%2C%20%22date%22%3A%20%222018-12-24T17%3A30%3A59%22%7D&pipelineLanguage=en",
                    async: "true",
                    // data: "sentence=" + editorText,
                    data:{dataJ:d},
                    success: resolve,
                    error: reject,
                    complete: function(){
                        $j('#cke_editor1').css({'display':'block'});
                        $j('.loading').css({'display':'none'});
                    }
                });
            })
    }

    function checkBoxes() {
        let checkedElements = new Array();
        $j("input:checkbox[name=selectionFilter]:checked").each(function () {
            checkedElements.push($j(this).val());
        });
        return checkedElements;
    }

    function pushChecks() {
        let checkedElements = checkBoxes();

        if (checkedElements.length > 0) {
            return true;
        }
        else return false;
    }




    function detectEntities(array, anonymize) {

        let result = '';

        var tokensArray = array.tokens;
        
        var entitiesArray = array.entities;
        
        responseData = array
        if(localStorage.getItem('html_code')==null){
            //file not detected 
            localStorage.setItem('editor1_data',document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerHTML)
        }
            
//      localStorage.setItem('editor1_data_copy',CKEDITOR.instances['editor1'].getData())
        localStorage.setItem('words','')
        localStorage.setItem('spans','')

        tokensArray.forEach((element, index, array) => {
            var word = element.text.content;
            $j(entitiesArray).filter(function (i,n){
                    if (n.name.searchWord(word)!=-1) {  
                        
                        var newJSON = $j.extend(element, {type:n.type});
                        n.name = n.name.replace(word, " ");
                        
                    } 
                });
        });    

        let checkedElements = checkBoxes();
        //consoleLogs(checkedElements)
        tokensArray.forEach((element, index, array) => {
            var word = element.text.content;
            var tag = element.type;
            var position = index+1;
//            consoleLogs(word+' '+tag+' '+position)
            pushChecks();
                if ($j.inArray(tag, checkedElements) > -1) {
                    if (!anonymize) {
                        result = getDetectResult(tag, result, word, position);
                    }
                    else {
                        result = getAnoymizeResult(tag, result, word, position);
                    }
                }
                else {
                    result += word + " ";
                }

        

        })

        $j("#editor").html(" ");
        $j("#editor").html(result);
        changeHTML_anonymize_detect()
        //CKEDITOR.instances['editor1'].setData(localStorage.getItem('editor1_data'));
        //don't touch this .
        initializeTooltipNameOfPerson();

    }


    $j('#returnOldValue').click(function () {
        var parent_id = $j(this).parent().attr('id');
        var toChangeElement = $j(parent_id).att('data-word');
        consoleLogs(parent_id);
        consoleLogs(toChangeElement);
    });


});


function colorEntitiesAnoynmize(word, result, color, title, position) {

    dataContent = buildHtml(position, word, title, true);    
    words=localStorage.getItem('words').split(',')
    words.push(word)

    localStorage.setItem('words',words)
    word = "<span class='namePerson' "
        + "style='color:" + color + ";' "
        + "id= 'p" + position + "'"
        + "data-html='true' "
        + "data-tippy-content='" + dataContent + "' "
        + "data-word='" + word + "'" + "'> "
        + "X"
        + "</span>";
    result += word + " ";
    spans=localStorage.getItem('spans').split(',')
    spans.push(word)
    localStorage.setItem('spans',spans)
    return result;
}

function buildHtml(position, word, title, anonymize) {

    result =
        "<div class=\"card\" style=\"width: 18rem;\">" +
        "<div class=\"card-header\ style=\"color:blue\">" + title + "</div>" +
        "<div class=\"list-group\">";

    if (anonymize) {
        var add = "<a href=\"#!\" class=\"list-group-item active list-group-item-action\" id =\"p" + position + "\" onclick=\"returnOldValue(this)\">Return to: <strong>" + word + "</strong></a>";
        result = result + add;
    }
    else {
        var add = "<a href=\"#!\" class=\"list-group-item active list-group-item-action\" id =\"p" + position + "\" onclick=\"makeAnX(this)\">Anonymize this word" + "</a>";
        result = result + add;
    }
    result = result + "</div>" + "</div>";

    return result
}

function colorEntitiesDetect(word, result, color, title, position) {
    dataContent = buildHtml(position, word, title, false);

    words=localStorage.getItem('words').split(',')
    words.push(word)
    localStorage.setItem('words',words)
    word = "<span class='namePerson' "
        + "style='color:" + color + ";' "
        + "id= 'p" + position + "'"
        + "data-html='true' "
        + "data-tippy-content='" + dataContent + "' "
        + "title='" + title + "'>"
        + word
        + "</span>";
    spans=localStorage.getItem('spans').split(',')
    spans.push(word)
    localStorage.setItem('spans',spans)
    result += word + " ";
    return result;
}

function getDetectResult(tag, result, word, position) {
    if (tag == "PERSON") {
        result = colorEntitiesDetect(word, result, "red", "Name Of Person", position);
    }
    else if (tag == "WORK_OF_ART") {
        result = colorEntitiesDetect(word, result, "#9000ff", "work of art", position);
    }
    else if (tag == "PHONE_NUMBER") {
        result = colorEntitiesDetect(word, result, "##ff009b", "work of art", position);
    }
    else if (tag == "LOCATION") {
        result = colorEntitiesDetect(word, result, "#9bee0c", "location", position);
    }

    else if (tag == "NUMBER") {
        result = colorEntitiesDetect(word, result, "orange", "A Number", position)
    }

    else if (tag == "MONEY") {
        result = colorEntitiesDetect(word, result, "green", "Money", position)
    }

    else if (tag == "DATE") {
        result = colorEntitiesDetect(word, result, "purple", "Date or time", position)
    }
    else if (tag == "OTHER") {
        result = colorEntitiesDetect(word, result, "purple", "Date or time", position)
    }
    else if (tag == "ORGANIZATION") {
        result = colorEntitiesDetect(word, result, "aqua", "Organsation", position)
    }
    return result;
}

function getAnoymizeResult(tag, result, word, position) {
    if (tag == "PERSON") {
        result = colorEntitiesAnoynmize(word, result, "red", "Name Of Person", position);
    }
    else if (tag == "ORGANISATION") {
        result = colorEntitiesAnoynmize(word, result, "purple", "Date or time", position)
    }
    else if (tag == "PHONE_NUMBER") {
        result = colorEntitiesAnoynmize(word, result, "##ff009b", "work of art", position);
    }
    else if (tag == "COUNTRY") {
        result = colorEntitiesAnoynmize(word, result, "blue", "Name of Country", position);
    }

    else if (tag == "NUMBER") {
        result = colorEntitiesAnoynmize(word, result, "orange", "A Number", position)
    }

    else if (tag == "MONEY") {
        result = colorEntitiesAnoynmize(word, result, "green", "Money", position)
    }
    else if (tag == "DATE") {
        result = colorEntitiesAnoynmize(word, result, "purple", "Date or time", position)
    }
    else if (tag == "WORK_OF_ART") {
        result = colorEntitiesAnoynmize(word, result, "#9000ff", "work of art", position)
    }
    return result;
}

function initializeTooltipNameOfPerson() {
    tippy('.namePerson', {
        // content: document.querySelector('#template1').innerHTML,
        delay: 100,
        arrow: true,
        arrowType: 'round',
        size: 'large',
        duration: 500,
        animation: 'scale',
        interactive: true,
        theme: "light"
    });
}

function returnOldValue(element) {
    // get the clicked element and append it with the saved attribute in span and make it back again
    var spanElement = document.getElementById(element.id);
    var elementOldValue = spanElement.getAttribute("data-word");
    spanElement.innerHTML = elementOldValue;
    spanElement.style = 'color:black;';
}

function makeAnX(element) {
    var spanElement = document.getElementById(element.id);
    spanElement.innerHTML = "X";
    spanElement.style = 'color:black;'
}




//the algorithm need to be more efficiant 


function setStringAt(str,index,oldString,newString) {
    if(index > str.length-1) return str;
    var t=oldString.length;
    return str.substr(0,index) + newString + str.substr(index+t);
}   

function initializeTooltipNameOfPerson_2(words,spans) {
    words = words.split(',').slice(1)
    spans = spans.split(',').slice(1)
    var newHTML=localStorage.getItem("editor1_data")

    var lastIndex,text,tmp,s;

    var indexs = [];
    for(var i=0;i<words.length;i++){
        wordIndex = words[i]
        lastIndex = words.slice(0,i).indexOf(wordIndex);
        if (lastIndex==-1) {
            //var rx = new RegExp('>(.*?)' +wordIndex+'(.*?)</', 'gi');

            s=newHTML.search(words[i])
            if(s!=-1){
            newHTML=  s;  
            }
        }
        else {
//            text = newHTML.substr(indexs[i]+words[i].length)
        
            text = newHTML.substr(indexs[lastIndex]+words[lastIndex].length)
            tmp=text.search(words[i])
            if(tmp!=-1){
                indexs.push(indexs[lastIndex]+words[lastIndex].length)
            }
        }
    }
    
    for(var j=1;j<indexs.length;j++){
        for(var k=0;k<j;k++){
            indexs[j]=indexs[j]+ spans[k].length-words[k].length              
}
    }
    for(var i=0;i<spans.length;i++){
        newHTML=setStringAt(newHTML,indexs[i],words[i],spans[i]);
    }
    localStorage.setItem("editor1_data",newHTML)

    

}


/////////////////////////////////////////////////////////////
function changeHTML_anonymize_detect() {
    words = localStorage.getItem("words").split(',').slice(1);
    spans = localStorage.getItem("spans").split(',').slice(1);
    var i=0;
    if(localStorage.getItem('html_code')==null){
        //file not detected 
        document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerHTML =localStorage.getItem('editor1_data') ; 
    }else{
        document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0].innerHTML =localStorage.getItem('html_code') ; 
    }

    while(i<words.length){
        counter = 0
    var node = document.getElementById('cke_editor1').childNodes[1].childNodes[1].childNodes[0]
    highlightText(words[i],spans[i],node)
    i++;
    }
}


function clearLocalStorage(){
    localStorage.removeItem('editor1_data')
    localStorage.removeItem('html_code')
    localStorage.removeItem('html_code_to_download')
    localStorage.removeItem('spans')
    localStorage.removeItem('words')
    
}




var counter = 0;


function highlightText(what,span, node) {
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
                var replacement = span ; //'<span id="'+ID+'" style="background-color:#f0da1e">'+what+'</span>';
                var textBlock = nodeList[x].textContent;
                //var regex = new RegExp('\\b' + what + '\\b');
                var searchIndex = nodeList[x].textContent.indexOf(what);
                while(searchIndex >= 0){
                    ++counter;           
                    replacement = span //'<span id="'+ID+'" style="background-color:#f0da1e">'+what+'</span>';         
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
            highlightText(what, span,nodeList[x]);
        }
    }
}




