const comunityJson =
{
  "rio": "La Rioja: Bretón de los Herreros (Logroño), Café Teatro (Logroño)",
  "can": "Canarias : Teatro Guiniguada (Gran Canaria), San Cristóbal de la Laguna (Tenerife)",
  "ast": "Asturias: Campoamor (Gijón), Jovellanos (Oviedo)",
  "gal": "Galicia: Colón (La Coruña), Jofre (Ferrol), Teatro Rosalía de Castro (La Coruña)",
  "mad": "Madrid: EDP Gran Vía (Madrid), Rialto (Madrid), Coliseum de Madrid (Madrid)",
  "cyl": "Castilla y León: Liceo (Salamanca), Calderón (Valladolid), Principal (Zamora)",
  "ara": "Aragón: De las equinas (Zaragoza), Arbolé (Zaragoza), Olimpia (Huesca)",
  "cat": "Cataluña: Coliseum (Barcelona), Nacional de Cataluña (Barcelona) Principal (Barcelona)",
  "val": "Comunidad Valenciana: Gran Teatro de Elche (Elche), Palacio de las Artes Reina Sofía (Valencia), Teatro Castelloón de la Plana (castellón)",
  "clm": "Castilla La Mancha: El Rojas (Toledo), Circo (Albacete), Bueno Vallejo (Guadalajara)",
  "mur": "Murcia: Teatro Romea (Murcia), Circo (Murcia)",
  "ext": "Estremadura: Gran Teatro (Cáceres), Alcázar (Plasencia), Romano (Mérida)",
  "and": "Andalucía: Alambra (Granada), Cervantes (Málaga), Falla (Cádiz)",
  "eus": "País Vasco: Arriaga (Bilbao), Victoria Eugenia (San Sebastián), Principal (Vitoria)",
  "nav": "Navarra: UNIKO (Pamplona), Auditorio de Berriozar (Pamplona)",
  "bal": "Islas Baleares: Principal de Palma (Palma) Trui Teatr (Palma)",
  "ica": "Islas Canarias: Teatro Guiniguada (Gran Canaria), San Cristóbal de la Laguna (Tenerife)"
}


// const modalButton = document.getElementById("buttonModal");

const comunidades = document.querySelectorAll(".g");
const secondaryComunities = document.querySelectorAll(".secondary-layer")

// console.log("boton", modalButton);

/*
 *   Función modal
 */
const handleModalMap = (title) => {

  let d = document;
  // if (d.getElementById("modalMap")) return;

  // Container
  let modalContainer = d.createElement("div");
  modalContainer.id = "modalMap";
  modalContainer.classList.add("modal-maps");

  // Contenido
  let modalContent = d.createElement("div");
  modalContent.classList.add("modal-maps-content");

  // Cabecera
  let modalHeader = d.createElement("div");
  modalHeader.classList.add("modal-maps-header");
  modalHeader.style.display = ("flex");
  modalHeader.style.justifyContent = ("space-between");

  // Titulo
  let modalTitle = d.createElement("h3");
  modalTitle.appendChild(d.createTextNode(title));
  // modalTitle.innerHTML = title;

  modalHeader.appendChild(modalTitle);
  modalContent.appendChild(modalHeader);
  modalContainer.appendChild(modalContent);

  //boton cerrar
  let buttonCloseModal = d.createElement("button");
  let svgCloseButton = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
  let pathSvgCloseButton = document.createElementNS(
    'http://www.w3.org/2000/svg',
    'path'
  );

  buttonCloseModal.style.textAlign = ("right");
  buttonCloseModal.style.display = ("flex");
  buttonCloseModal.classList.add = "boton_cerrar";

  svgCloseButton = d.createElementNS('http://www.w3.org/2000/svg', 'svg');
  svgCloseButton.setAttribute('fill', 'none');
  svgCloseButton.setAttribute('stroke', 'black');
  svgCloseButton.classList.add('post-icon');
  svgCloseButton.style.width = ("23px");
  svgCloseButton.style.height = ("21px");

  pathSvgCloseButton.setAttribute(
    'd',
    'M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z'
  );
  pathSvgCloseButton.setAttribute(
    'fill',
    '#0092E4'
  );

  svgCloseButton.appendChild(pathSvgCloseButton);
  buttonCloseModal.appendChild(svgCloseButton);

  modalHeader.appendChild(buttonCloseModal);

  // Body
  let modalBody = d.createElement("div");
  modalBody.classList.add("modal-body");


  // Montamos Elemento
  modalContainer.appendChild(modalContent);
  modalContent.appendChild(modalHeader);
  modalContent.appendChild(modalBody);


  //aqui evito que pulsando otras partes de dentro del modal que no sean el icono de cerrado, este se cierre
  modalContent.addEventListener("click", (event) => {
    event.stopPropagation();
  })

  modalTitle.addEventListener("click", (event) => {
    event.stopPropagation();
  })

  modalHeader.addEventListener("click", (event) => {
    event.stopPropagation();
  })


  //controlo el evento del icono para cerrar el modal
  buttonCloseModal.addEventListener('click', () => {
    modalContainer.style.display = "none";
  })


  //control de pinchar fuera del modal y se cierre
  document.addEventListener('click', (evento) => {
    evento.preventDefault();
    modalContainer.style.display = "none";
    console.log("entra");
  })



  d.getElementsByTagName("body")[0].appendChild(modalContainer);

};

// modalButton.addEventListener("click", (evento) => {
//   evento.stopPropagation();
//   handleModalMap();
// })

comunidades.forEach((comunidad) => {
  comunidad.addEventListener("click", (evento) => {
    evento.stopPropagation();
    console.log("pinchaComunidad");

    com = comunidad.getAttribute('data-key');
    console.log("atributo data-key -->", com);
    // let completeComunity = `${comunityJson[com]}`;
    // let completeComunity = comunityJson[`${com}`];
    let completeComunity = comunityJson[com];
    console.log("comunidad completa -->", completeComunity)

    handleModalMap(completeComunity);
  })
})

secondaryComunities.forEach((comunidad) => {
  comunidad.addEventListener("mouseenter", () => {
    console.log("entrrrrraaaaaa2");

    let firsPath = comunidad.children[0];
    let secondPath = comunidad.children[1];

    firsPath.setAttribute("fill", "red");
    secondPath.setAttribute("fill", "red");
    // svgCloseButton.setAttribute('fill', 'none');

  })
})
