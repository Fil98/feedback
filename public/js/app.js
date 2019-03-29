class Message {

    static async send() {
        let form = document.forms[0];
        let fd = new FormData(form);
        let object = {};
        fd.forEach(function(value, key){
            object[key] = value;
        });
        let json = JSON.stringify(object);
        let response = await fetch('/api/messages', {
            method: 'POST',
            body: json,
        }).catch(err=> {
            console.log("Post message error: " + err);
        });

        Message.getMessages();
    }

    static async getMessages() {
        let response = await fetch('/api/messages');
        if (response.ok) {
            let result = await response.json();

            let el = document.querySelector('#messages,#data');
            let html = '';

            for (let item of result) {

                html += `<hr><b>Текст сообщения: </b><div class='messages__message'>${Message.escapeHtmlTags(item.message)}</div></hr>`
                html += `<b>Дата отправки: </b> <div class='messages__data'>${item.data}</div>`
            }
            el.innerHTML = html;
        }
    }

    static escapeHtmlTags(html) {
    
        return html.replace(/[&<>]/g, Message.replaceTag);
        return html;
    }

    static replaceTag(tag) {

        let tagsToReplace = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;'
        };

        return tagsToReplace[tag] || tag;
    }
    // static async Protect() {
    //     function NotRunScript(){

    //         let setInnerHTML = function(elm, html) {

    //             elm.innerHTML = html;

    //             Array.from(elm.querySelectorAll("script")).forEach( oldScript => {
    //                 const newScript = document.createElement("script");
    //                 Array.from(oldScript.attributes)
    //                     .forEach( attr => newScript.setAttribute(firstname.name, firstname.value) );

    //                 newScript.appendChild(document.createTextNode(oldScript.innerHTML));
    //                 oldScript.parentNode.replaceChild(newScript, oldScript);
    //                 $0.innerHTML = HTML //does *NOT* run <script> tags in HTML
    //             });
    //         }
    //     }
    //     function tags(firstname,lastname,surname,message,mail,subject) {
    //         return str.replace(/&/g,'').replace(/</g,'').replace(/>/g,'') ;
    //     }

            /* function EscapeHtml(){
        let tagsToReplace = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;'
        };
        function safe_tags_replace(str) {
            return str.replace(/[&<>]/g, replaceTag);
        }
    }*/
}

window.addEventListener('DOMContentLoaded', Message.getMessages, false);

