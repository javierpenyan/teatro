const form_añadir = document.querySelector("#video-formu");

const url = document.querySelector("#url");

// const actor = document.querySelector("#actor");

// const b_nuevo = document.getElementById("nueva");

const tabla_video = document.querySelector("#add_video");

const url_video = document.querySelector("#enviar_url");

// const actor = document.querySelector("#actor");

const actor = document.querySelector("#id_p");
const id_actor = actor.value;

console.log("id1-->", actor.value);

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
				}, 1000);
				observa.unobserve(entry.target);
			}

		});
	}, options);


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
	nueva_fila.style.visibility = "hidden";

	nueva_fila.id = "VIDEO_" + json["Id"];

	console.log("id a borrar ->", nueva_fila.id)

	//CREA EL DIV CON EL VIDEO
	let div_video = createIframe(json["url"]);
	nueva_fila.appendChild(div_video);

	//============================================================================================	

	let b_modal = document.createElement("a");
	let url = json["url"];
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

	nueva_fila.appendChild(b_modal);
	//================================================================================================

	observa.observe(nueva_fila);

	return nueva_fila;
}

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
		const respuesta = await fetch(`../api/videoById.php?id=${id_actor}`);
		//DATOS_LIBROS SE OBTIENE DE LA API INTERNA QUE NOS DEVUELVE LO QUE HAY EN LA BASE DE DATOS
		const datos_video = await respuesta.json();

		if (Array.isArray(datos_video) && datos_video.length > 0) {
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
		}
		
	})();
} else {
	//CARGAR LA PAGINA DESPUES DE LA PRIMERA VEZ EL SESSION YA TIENE QUE TENER DATOS
	//METER LOS DATOS EN LA TABLA DEL INTERFAZ
	filterById(id_actor).forEach(
		(video) => {
			let item = nuevoVideo(JSON.parse(video))
			if (item) {
				tabla_video.appendChild(nuevoVideo(JSON.parse(video)));
			}
		}
	)
}