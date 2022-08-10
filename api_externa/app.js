const precio = {
  "1" : "../asset/imagenes/gratis.png",
  "0" : "../asset/imagenes/pago.png"
}


const tabla = document.querySelector("#lista_api");
// const cargando = document.querySelector("#cargando");
const boton = document.querySelector("#descargar");


boton.addEventListener("click", async () => {
  // cargando.style.display = "block";
  const respuesta = await fetch("https://datos.madrid.es/egob/catalogo/206974-0-agenda-eventos-culturales-100.json");
  const datos = await respuesta.json();

  const lista_eventos = datos["@graph"];
  tabla.innerHTML = "";
  lista_eventos.forEach(
    (evento) => {
      tabla.appendChild(crearFila(evento["title"],
        evento["dtstart"],
        evento["event-location"], evento["free"]));
    });
  
  // cargando.style.display = "none";
});


const crearFila = (tittle, date, place, free) => {
  const fila = document.createElement("tr");

  const titulo = document.createElement("h3");
  titulo.innerText = tittle;

  const fecha = document.createElement("h4");
  fecha.innerText = date;

  const lugar = document.createElement("h4");
  lugar.innerText = place;

  const coste = document.createElement("img");
  coste.src = precio[free];
  coste.style.width = "100px";

  const td_titulo = document.createElement("td");
  td_titulo.appendChild(titulo);

  const td_lugar = document.createElement("td");
  td_lugar.appendChild(lugar);

  const td_fecha = document.createElement("td");
  td_fecha.appendChild(fecha);

  const td_precio = document.createElement("td");
  td_precio.appendChild(coste);

  fila.appendChild(td_titulo);
  fila.appendChild(td_fecha);
  fila.appendChild(td_lugar);
  fila.appendChild(td_precio);

  return fila;
}


//https://datos.madrid.es/portal/site/egob/menuitem.214413fe61bdd68a53318ba0a8a409a0/?vgnextoid=b07e0f7c5ff9e510VgnVCM1000008a4a900aRCRD&vgnextchannel=b07e0f7c5ff9e510VgnVCM1000008a4a900aRCRD&vgnextfmt=default
//ruta de la pagina
