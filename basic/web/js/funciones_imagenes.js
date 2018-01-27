function previsualizacion_img(input_file) 
{
	$.each(input_file.files, function(itr, file)
	{
		if (file.name.length>0) 
		{
			if (!file.type.match('image.*')) // Solo previsualiza imagenes
				return true; 
			else
			{
				//Remueve las previsualizadas anteriormente para agregar las nuevas.
				
				// Por ahora no tengo muy claro como jugar con el input file (agregando, removiendo), 
				// ficheros directamente desdes js/ajax usando yii2, pues este no responde demasiado bien
				// de la forma que lo estoy haciendo...
				
			   $('#previsualizador').html(''); 
			   
			   var reader = new FileReader();
			   
			   reader.onload = function(e) 
			   {
				   $('#previsualizador').append(
				   '<li id="id_'+itr+'" class="imagen_miniatura"><a class="imagen_miniatura_lnk" href="javascript:void(0)" onclick="ver_imagen(this);"> \
				   <img class="imagen_style" src="' + e.target.result + '" \
				   title="'+ escape(file.name) +'" /></a><br /></li>');
			   }
			   reader.readAsDataURL(file);
		   }
		}
		else {  return false; }
	});
}

function previsualizar_imagen(ruta_imagen, id, user_ID, div_padre) 
{	
   //$('#previsualizador').html(''); 

   //Creamos un div, cuya clase sea imagen_miniatura
    var div = document.createElement('li');
    div.className = 'imagen_miniatura';
   
   //Agregamos el código referente a la imagen como html.
   div.innerHTML ='<a class="imagen_miniatura_lnk" href="javascript:void(0)" onclick="ver_imagen(this);"><img id="img_'+id+':'+user_ID+'" class="imagen_style" src="' + ruta_imagen + '" /></a><br />';
 
	//Insertamos este nuevo div, en el previsualizador.
   document.getElementById(div_padre).appendChild(div);

}

function ver_imagen(imagen) 
{	
	var div = document.createElement("div");
		div.className = 'imagen_backdrop';
		
	document.body.appendChild(div);

	div = document.createElement("div");
	div.className = 'div_imagen_centrada';
	div.innerHTML ='<div class="imagen_centrada_vertical" onclick="retirar_visor(event);"><img src="'+imagen.getElementsByTagName('img')[0].src+'"></img></div>';
	document.body.appendChild(div);
	
}

function retirar_visor(ev) 
{	
	if($(ev.target).attr('class') == "imagen_centrada_vertical")
	{
		$(".imagen_backdrop").remove();
        $(".div_imagen_centrada").remove(); 
	}
	
}

function auto_submit() 
{	
	 document.getElementById("previsualizador").parentElement.parentElement.submit();
}

function barra_herramientas_imagenes(url_base, id_user, id_alerta, creador, admin) 
{	
	var x = document.getElementsByClassName("imagen_miniatura");
	var i;
	
	for (i = 0; i < x.length; i++) {
		var div = document.createElement("div");
		div.className = 'div_herramientas_imagen';
					
		var img = x[i].getElementsByTagName('a')[0].getElementsByTagName('img')[0];

		var id = img.getAttribute('id');				
		id = id.replace("img_", "");
		
		var r_id = id.split(":");
		
		
		if(id_user == r_id[1] || admin==1)
		{

			div.innerHTML = '<a class="herramienta_imagen" href="'+url_base+'/alerta-imagenes/delete?id='+r_id[0]+'" title="Eliminar" aria-label="Eliminar" data-pjax="0" data-confirm="¿Está seguro de eliminar esta imagen?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>';
			div.innerHTML = div.innerHTML + '<a class="herramienta_imagen" href="'+url_base+'/alerta-imagenes/update?id='+r_id[0]+'" title="Actualizar" aria-label="Actualizar" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>';
		}			
		x[i].appendChild(div);	

	} 
		
	if(admin==1 || creador==1 )
	{	
		var div_padre = document.getElementById("previsualizador").parentElement;
		div_padre.innerHTML = div_padre.innerHTML + '<input style="display:none" name="explorar_ficheros[]" id="explorar_ficheros" onchange="auto_submit();" multiple="multiple" type="file">';
		
		var btn = document.createElement("a");
		btn.className = 'btn btn-success btn-right';
		btn.setAttribute('onclick', 'document.getElementById(\'explorar_ficheros\').click();');
		btn.innerHTML = 'Agregar nuevas imágenes';
		
		div_padre.appendChild(btn);
	}
	
}






