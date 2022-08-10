const form_añadir = document.querySelector("#video-formu");

const url = document.querySelector("#url");

// const actor = document.querySelector("#actor");

// const b_nuevo = document.getElementById("nueva");

const tabla_video = document.querySelector("#add_video");

const url_video = document.querySelector("#enviar_url");

const actor = document.querySelector("#actor");
const id_actor = actor.value;


//OBSERVADOR DE SCROLL QUE HACE EL EFECTO LAZY LOAD
const options = { threshold: 1 };
const observa = new IntersectionObserver(
	(entries) => {
		entries.forEach((entry, posicion) => {
			if (entry.isIntersecting) {
				const video = entry.target
				const datos_video=JSON.parse(sessionStorage.getItem(video.id));
				setTimeout(() => {
					video.style.visibility = "visible";
					datos_video.src = datos_video["url"];
				}, 250);
				observa.unobserve(entry.target);
			}

		});
	}, options);



//solamente puedo introducir los videos y verlos si soy el actor
//con el id propio (javi los de javi y de javi)


//GESTION DE LA TABLA	
const borrarVideo = async (event, clave_video) => {
	event.preventDefault();
	
	// cargando.style.display="block";
	const datos_video=JSON.parse(sessionStorage.getItem(clave_video));
	
	console.log("clave_video->",clave_video);

	console.log("datos_video->",datos_video);
	
	let response = await fetch("../api/videoDelete.php?id="+datos_video["Id"]);

	let {success} = await response.json();

	if (success) {
		console.log("datos_video_id", datos_video["Id"]);
	
		const fila_a_borrar = document.querySelector("#" + clave_video)
		fila_a_borrar.remove();
		sessionStorage.removeItem(clave_video);
		mensajeOk("Borrado con éxito");
	}


	//BORRAR DE LA BASE DE DATOS CON EL ID

	// cargando.style.display="none";
}

const createIframe = (url, isModal = false) => {
	let video = document.createElement("iframe");
	video.src = url
	video.classList.add(...(!isModal ? ["w-50"] : ["w-100", "h-100"]));
	video.style.width = "420px";
	video.style.height ="345px"
	let div_video = document.createElement("div");
    div_video.appendChild(video);
	div_video.classList.add(...(!isModal ? ["text-center"] : ["h-100", "d-flex", "align-items-center", "w-100"]));
	
	return div_video;
}


const nuevoVideo = (json) => {
	let nueva_fila = document.createElement("div");
	nueva_fila.id = "VIDEO_" + json["Id"];
	nueva_fila.style.visibility = "hidden";
	let url = json["url"];

	console.log("id a borrar ->", nueva_fila.id)


	let creoEnvolvente = document.createElement("div");
	creoEnvolvente.classList.add("row", "d-flex", "justify-content-center");
	let envolvente2 = document.createElement("div");
	envolvente2.classList.add("col-2");
	


	//CREA EL DIV CON EL VIDEO
	// let video = document.createElement("iframe");
	// video.src = json["url"];
	// video.classList.add("w-50");
	// video.style.width = "420px";
	// video.style.height ="345px"
	// let div_video = document.createElement("div");
    // div_video.appendChild(video);
	// div_video.classList.add("text-center");
	nueva_fila.appendChild(createIframe(url));
{/* <div class="row d-flex">
    <div class="col-2">
    <a href="#" class="btn btn-danger">Eliminar</a>
	</div><div class="col-2"
    <a href="../php/video_completo.php?url=https://www.youtube.com/embed/dcHplQrJs0o" class="btn btn-danger">acceder</a>
        
    </div>
</div> */}
	//============================================================================================	
	//CREA EL BOTON DE BORRADO
	let borrar = document.createElement("a");
	borrar.innerText = "Eliminar";
	borrar.href = "#";
	
	borrar.classList.add("btn", "btn-danger", "m-2");

	//MANEJAR EVENTO DE CLICK SOBRE EL BOTON
	//borrar.addEventListener("click", borrarVideo(nueva_fila.id));
	borrar.addEventListener("click", (event) => borrarVideo(event, nueva_fila.id));
	envolvente2.appendChild(borrar);

	// let div_borrar = document.createElement("div");
	// div_borrar.appendChild(borrar);
    // div_borrar.classList.add("text-center");

	//Crear boton del modal
	// let b_modal = document.createElement("button");
	// b_modal.innerText = "Ampliar";
	// b_modal.href = "#";
	// b_modal.classList.add("btn", "btn-primary");
	// b_modal.toggleAttribute = "modal";
	// b_modal.formTarget = "#exampleModal";

	let b_modal = document.createElement("a");
	let id_v = json["url"];
	b_modal.innerText = "acceder";
	//b_modal.href = "../php/video_completo.php?url="+id_v;
	b_modal.classList.add("btn", "btn-primary", "m-2");
	//data-bs-toggle="modal" data-bs-target="#exampleModal"
	b_modal.setAttribute('data-bs-toggle', 'modal');
	b_modal.setAttribute('data-bs-target', '#exampleModal');

	b_modal.addEventListener('click', (event) => {
		//elemento.parentElement.parentElement.parentElement.firstChild.firstChild
		let modalContent = document.querySelector('#video-modal-content');

		if (modalContent) {
			modalContent.innerHTML = '';
			modalContent.appendChild(createIframe(url, true))			
		}
	})

	envolvente2.appendChild(b_modal)
	nueva_fila.appendChild(envolvente2);

	creoEnvolvente.appendChild(envolvente2);
	nueva_fila.appendChild(creoEnvolvente);
	//================================================================================================

	observa.observe(nueva_fila);

	return nueva_fila;
}


//=========AÑADIR UNA VIDEO DESDE EL FORMULARIO======================

url_video.addEventListener("click",async (evento) => {
	evento.preventDefault();
		console.log(url);
	if (url.value.trim().length == 0) {
		mensajeError("VIDEO seleccionado incorrecto");
	} else {
		//cargando.style.display = "block";
		//MANDAR LOS DATOS DEL FORMULARIO A LA API DE INSERTAR

		const datos_formulario=new URLSearchParams(new FormData(form_añadir));
		
		const respuesta=await fetch("../api/videoInsertar.php",
		{
			method:"POST",
			body:datos_formulario
		});
		// console.log('hola')
		const { response } = await respuesta.json();

		let id_video = response.id;

		// console.log('hola 2 ')
		const datos_video = {
            "Id":id_video,
			"url": url.value.trim(),
			"actor": actor.value,
		};//aqui estoy creando el json de la api

		const nuevo = nuevoVideo(datos_video);
		tabla_video.appendChild(nuevo);
		sessionStorage.setItem("VIDEO_" + id_video, JSON.stringify(datos_video));

		//cargando.style.display = "none";
		form_añadir.reset();
		document.documentElement.scrollTop = document.documentElement.scrollHeight;
		mensajeOk("Añadido correctamente");
	}
});


const hasVideoInSessionStorage = (id_actor) => {
	Object.values(sessionStorage).some(el => {
		let obj = JSON.parse(el);
		return obj.actor == id_actor;
	})
}

const filterById = (id) => {
	return Object.values(sessionStorage).filter((el) => {
		let obj = JSON.parse(el);
		return obj.actor == id;
	})
}

//AÑADIR LOS DATOS DEL STORAGE PARA MANEJAR LA APLICACION A TRAVES DE ELLOS Y NO TENER QUE USAR SIEMPRE LA BASE DE DATOS

if (!hasVideoInSessionStorage(id_actor)) {
	//LA PRIMERA VEZ QUE SE CARGUE LA PAGINA-->METERLO TODO EN EL SESSION

	(async () => {
		// cargando.style.display = "block";
		const respuesta = await fetch("../api/videoTabla.php");
		//DATOS_LIBROS SE OBTIENE DE LA API INTERNA QUE NOS DEVUELVE LO QUE HAY EN LA BASE DE DATOS
		const datos_video = await respuesta.json();

		datos_video.forEach((video) => {
			sessionStorage.setItem("VIDEO_" + video["Id"],
				JSON.stringify(video))
		});
		//METER LOS DATOS EN LA TABLA DEL INTERFAZ
		filterById(id_actor).forEach(
			(video) => {
				tabla_video.appendChild(nuevoVideo(JSON.parse(video)));
			}
		)
		// cargando.style.display = "none";
	})();
	
} else {
	//CARGAR LA PAGINA DESPUES DE LA PRIMERA VEZ EL SESSION YA TIENE QUE TENER DATOS
	//METER LOS DATOS EN LA TABLA DEL INTERFAZ
	filterById(id_actor).forEach(
		(video) => {
			tabla_video.appendChild(nuevoVideo(JSON.parse(video)));
		}
	)
}













// (async function(){
// 	const url_video = document.querySelector("#enviar_url");

// 	const peticion = async (formulario) => {
// 		let respuesta = await fetch("videoInsertar.php", {
// 			method: 'POST',
// 			body: formulario
// 		  });

// 		return await respuesta.json();
// 	}

// 	if (url_video){
// 		url_video.addEventListener('click', (event) => {
// 			event.preventDefault();
// 			let url = document.querySelector('#url');
// 			if (url){
// 				let formulario = new FormData(document.getElementById("video-formu"))
// 				url = peticion(formulario);
// 			}

// 			if (url){
				

// 				console.log(url);
// 			}
// 		})
// 	}

// })();