// função disparada a partir do onclik do menu para carregamento da pagina
function carregaPagina(link){
        event.preventDefault()
        carrega = document.getElementById("carrega")
        carrega.innerHTML=""
        carrega_ajax=link.href
        const ajax = new XMLHttpRequest()
        ajax.open('GET', carrega_ajax)
        ajax.send()
        ajax.addEventListener('load', BuscaConteudo)
}


// evento disparado quando a requisição for completa
        function BuscaConteudo() {
        if(this.status == 200 && this.readyState==4) {
           var pagina = this.responseText;
           var carrega = document.getElementById("carrega")
            if (pagina) {
                carrega.innerHTML=pagina
            }

            } else {
                if(this.status == 404)
                    alert("Arquivo Não encontrado")
                     console.log('Somthing wrong happen:',this.status)
                } 
        }

function carregaEnvioDados2(event){
        event.preventDefault()
        carrega_ajax=event.target.action
        var formData = new FormData(event.target);
        const ajax = new XMLHttpRequest()
        ajax.open('POST', carrega_ajax)
        ajax.send(formData)
        ajax.addEventListener('load', BuscaConteudo2) 
}

function BuscaConteudo2() {
        if(this.status == 200 && this.readyState==4) {
           var pagina = this.responseText;
           var carrega = document.getElementById("carrega2")
            if (pagina) {
                carrega.innerHTML=pagina
            }

            } else {
                if(this.status == 404)
                    alert("Arquivo Não encontrado")
                     console.log('Somthing wrong happen:',this.status)
                } 
        }


