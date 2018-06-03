<div class="global-container">
	<span class="global-titre">Saisie d'une actualité</span>

	<div class="saisie-actus" style="">
		<div class="titre">
			<input class="saisie" type="text"
				placeholder="Titre de l'actualité..." />
		</div>
		<div class="prio">
			<input class="saisie" type="checkbox" />Prioritaire ?
		</div>
		<div class="mise_en_forme">
			<button class="fa fa-bold"
				onclick="document.execCommand('bold',false,null);"></button>
			<button class="fa fa-italic"
				onclick="document.execCommand('italic',false,null);"></button>
			<button class="fa fa-underline"
				onclick="document.execCommand('underline',false,null);"></button>
			<button class="fa fa-align-left"
				onclick="document.execCommand('justifyLeft',false,null);"></button>
			<button class="fa fa-align-center"
				onclick="document.execCommand('justifyCenter',false,null);"></button>
			<button class="fa fa-align-right"
				onclick="document.execCommand('justifyRight',false,null);"></button>
			<input type="color"
				onchange="document.execCommand('foreColor',true, this.value);"></input>
			<!-- <button class="fa fa-link" onclick="document.execCommand('insertImage',true,'style/datas/logoTPH.jpg');"></button> -->
		</div>
		<div class="contenu" contenteditable="true"></div>
	</div>
</div>