
	var img = document.querySelector("input[name='imagenes_prenda[]']");

	if( img ){
		img.addEventListener('change', show_image );
			img.addEventListener("click", delate_img);
	}

	function show_image(){

		var ctn_eliminados = 0;
			var imagenes_aceptadas = [], tot_delate = 0, pos = 0, pos_no_file = [], pos_no = 0;

		if( img.files.length <= 4){

			for (var i = 0; i < img.files.length; i++){

/*				validate_name(img.files[i].name);
*/				
				if( validate_types( img.files[i].type ) && size_file( img.files[i].size ) ){
					var blob_img_type_img = window.URL.createObjectURL(img.files[i]);//creamos el blob de la imagen
						imagenes_aceptadas[pos] = blob_img_type_img;
							pos++;							
				}else{
					pos_no_file[pos_no] = i;
						tot_delate++;
							pos_no++;
				}

			}

			if( imagenes_aceptadas.length == img.files.length ){
				paint_img( imagenes_aceptadas );
			}else{
				notification( pos_no_file, tot_delate );
			}

		}else{
			alert("Solo puede seleccionar 4 fotos como máximo.");
				remove_data_file_input();
		}

	}

		function validate_types(type_img_selected){

			var type_img_acept = [
								  "image/jpeg",
								  "image/jpg",
								  "image/png"
								];

				var ctn_equals = 0;

			for(var x = 0; x < type_img_acept.length; x++){
				if( type_img_selected === type_img_acept[x] ){
					ctn_equals++;
				}
			}

			if( ctn_equals > 0){
				return true;
			}

		}

			function size_file( size ){
				if( size <= 1048576){
					return true;
				}
			}
/*
		function validate_name(name_img){
			console.log( name_img );
		}*/

		function paint_img(blob_img_type_img ){

			var main_view = document.getElementById("img_seleccionadas");

				for(var x = 0; x < blob_img_type_img.length; x++){
					var view_img = document.createElement("img");
						view_img.src = blob_img_type_img[x];
							main_view.appendChild( view_img );
				}
		}


			function notification( pos_no_file, tot_delate ){
				alert("Se encontraron "+tot_delate+" archivos que no pertenecen a los formatos de imágenes aceptados, o el tamaño supera el límite que es de 1MB, verifíquelo.");
					remove_data_file_input();
						//console.log( pos_no_file );//posicion file no aceptados.
			}

				function remove_data_file_input(){
					document.getElementById("imagenes_prenda").value = null;
				}


					function delate_img(){
						var art_img = document.getElementById("img_seleccionadas")
						if( art_img.childNodes.length > 0){
							$("#img_seleccionadas img").remove();
								remove_data_file_input();
						}
					}

	$("#registrar").click(function(){
		save_data();
	})

		function save_data(){

			$("#info_prenda").on('submit', function(evt){

				evt.preventDefault();//evitamos que se redireccione la página.
					evt.stopImmediatePropagation();

				$.ajax({

					beforeSend:function(){
						bloquear_btn( true );
					},
					data: new FormData(this),
					contentType: false,
					cache:false,
   					processData:false,
					method:'POST',
					url:'../recursos/backend/registro/registro_prenda.php',

					success:function(data){

						var request = JSON.parse( data );

						switch(request.tipe){

							case request.tipe:
								alert(request.info);
									bloquear_btn( false );
							break;

						}
					}
				})

			})

		}

			function bloquear_btn(tipe){
				$("#registrar")[0].disabled = tipe;
			}


		$(document).ready(function(){
			mostrar_prendas();
		})

			function mostrar_prendas(){
				$.ajax({
					url:'../recursos/backend/consulta/consulta_prendas.php',
					method:'POST',
					data:{'tipe':true},
					success:function(data){

						var request = JSON.parse( data );
							var card_tra_long = 1;
								var div_info = ["Talla:", "Talla internacional:", "Tela:", "Precio:", "Precio anterior:", "Colores:", "Descripción extra:"];
									var dat_info = ["talla", "internacional", "tela", "precio", "precio_anterior", "colores", "descripcion"];
						
						for(var i = 0; i < request.length; i++){

								var card_tra = $("<div>").attr({id:"card_tra"}); //padre
									var cont_img = document.createElement("div");
										cont_img.id = "cont_img";
											var info = $("<div>").attr({id:"info"}); //hijo a;
											
							for(var img = 0; img < request[i]["img"].length/request[i]["img"].length; img++){
								var et_img = document.createElement("div");
									et_img.className = "img_prenda";
										et_img.style.backgroundImage = 'url("'+request[i]["img"][img]["url"]+request[i]["img"][img]["nombre"]+'")';
									cont_img.appendChild( et_img );
										card_tra.append( cont_img );//add
							}

								for(var x = 0; x <= 7; x++){

									var div_child_info_a = $("<div>"); // padre
										info.append( div_child_info_a );

											card_tra.append( info );//add


									if( x < 7){
										for(var y = 0; y < 2; y++){

											var div_child_info_b = $("<div>"); // hijos x2 div
												div_child_info_a.append( div_child_info_b );

												switch(y){
													case 0:
														info_div( div_info[x], div_child_info_b );
													break;

														case 1:
															info_div( request[i][dat_info[x]], div_child_info_b );
														break;
												}

										} //for y
									}else{
										var me_encanta = $("<div>").attr({id:"me_encanta"});
											var info_encanta = $("<div>").attr({id:"info_encanta", class:"info_encanta"});
												me_encanta.append( info_encanta );

											for(var z = 0; z < 3; z++){

												var div_child = $("<div>");
													info_encanta.append( div_child );

												switch(z){
													case 0:
														var img_div_child = $("<img>").attr({id:"img_encanta", class:"info_encanta", src:"../recursos/imagenes/me_gusta/corazon.png"});
															div_child.append( img_div_child );
													break;

														case 1:
															f_div_child(div_child, "Total de me encanta:");
														break;

													case 2:
														f_div_child(div_child, 0);
													break;
												}
											}

											div_child_info_a.append( info_encanta )

									}			

								}//for x

							$("#card_main_tra").append(card_tra); //add padre
							
						} // for one	
					}
				})
			}


		function info_div(info, div_child_info_b){
			div_child_info_b.text(info);
		}

			function f_div_child(div_child, txt){
				div_child.attr({class:"dat_encanta"}).text(txt);
			}
