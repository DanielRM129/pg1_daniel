window.onload = function(){
var formulario = document.getElementById("formulario")
formulario.addEventListener("submit", validaFormulario)
}

function validaFormulario(event){
	let formulario = document.getElementById("formulario")
	const numElementos = formulario.elements.length
	let submeter=true
	for(let i=0; i < numElementos; i++){
		let controle = formulario.elements[i];
		
		if(controle.value==""){
			if(controle.id == "arquivo")
				break;
			if(controle.id == "descricao")
				break;
			if(controle.id == "endereco")
				break;
			if(controle.id == "email_contato")
				break;
			if(controle.id == "cnpj")
				break;
			if(controle.id == "destino")
				break;
			if(controle.id == "venda")
				break;
			if(controle.id == "dt_saida")
				break;
			if(controle.id == "num_telefone")
				break;
			if(controle.id == "num_forn")
				break;
			
			controle.style.border="1px solid red"
			submeter=false
		}
	}
		if(submeter==false){
			alert('Preencher Campos Obrigatórios')
			event.preventDefault()
		}
}