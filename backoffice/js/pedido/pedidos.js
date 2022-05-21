

const form = document.getElementById('form-pedido');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    const resp = await sendData(formData);

    console.log(resp);
});

const sendData = async (formData) => {
    /* añado el id de la marca */
    const params = new URLSearchParams(document.location.search);
    const id = params.get('ref');

    const resp = await fetch(`http://localhost/urban/backoffice/controllers/PedidosController.php?id_pedido=${id}`, {
        method: 'POST',
        body: formData,
    });

    const data = await resp.json();

    //Si retorna true se subio correctamente
    return data;
}