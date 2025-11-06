// Function to get URL parameters
function getUrlParams() {
    const params = new URLSearchParams(window.location.search);
    return {
        nombre: params.get('nombre') || '',
        email: params.get('email') || '',
        texto: params.get('texto') || '',
        calle: params.get('calle') || '',
        numero: params.get('numero') || '',
        piso: params.get('piso') || '',
        puerta: params.get('puerta') || '',
        cp: params.get('cp') || '',
        localidad: params.get('localidad') || '',
        provincia: params.get('provincia') || '',
        pais: params.get('pais') || '',
        telefono: params.get('telefono') || '',
        color: params.get('color') || '#000000',
        copias: params.get('copias') || '1',
        resolucion: params.get('resolucion') || '',
        anuncio: params.get('anuncio') || '',
        fecha: params.get('fecha') || '',
        impresion: params.get('impresion') || 'bn',
        precio: params.get('precio') === 'si'
    };
}

// Format the address
function formatAddress(params) {
    const parts = [
        params.calle + ' ' + params.numero,
        params.piso + (params.puerta ? ' ' + params.puerta : ''),
        params.cp + ' ' + params.localidad,
        params.provincia,
        params.pais
    ].filter(part => part.trim() !== '');
    
    return parts.join(', ');
}

// Format the date
function formatDate(dateStr) {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('es-ES');
}

// Get anuncio display text
function getAnuncioText(value) {
    const anuncios = {
        'atico': 'Ático en Barcelona',
        'apartamento': 'Apartamento en Sevilla',
        'chalet': 'Chalet en Málaga'
    };
    return anuncios[value] || value;
}

// Calculate price based on copies and color
function calculatePrice(copies, isColor) {
    const copiesNum = parseInt(copies, 10);
    let basePrice;
    
    if (copiesNum <= 10) {
        basePrice = isColor ? 15 : 10;
    } else if (copiesNum <= 50) {
        basePrice = isColor ? 12 : 8;
    } else {
        basePrice = isColor ? 8 : 5;
    }
    
    return basePrice;
}

// Fill the table with form data
function fillTable() {
    const params = getUrlParams();
    const tableRows = document.querySelectorAll('table tbody tr');
    
    tableRows.forEach(row => {
        const header = row.querySelector('th').textContent.toLowerCase();
        const cell = row.querySelector('td');
        
        switch(header) {
            case 'nombre':
                cell.textContent = params.nombre;
                break;
            case 'correo electrónico':
                cell.textContent = params.email;
                break;
            case 'dirección':
                cell.textContent = formatAddress(params);
                break;
            case 'teléfono':
                cell.textContent = params.telefono || 'No proporcionado';
                break;
            case 'color de portada':
                cell.innerHTML = `<span style="display:inline-block;width:20px;height:20px;background:${params.color};"></span> ${params.color}`;
                break;
            case 'número de copias':
                cell.textContent = params.copias;
                break;
            case 'resolución':
                cell.textContent = params.resolucion + ' DPI';
                break;
            case 'anuncio':
                cell.textContent = getAnuncioText(params.anuncio);
                break;
            case 'fecha de recepción':
                cell.textContent = formatDate(params.fecha) || 'No especificada';
                break;
            case 'impresión':
                cell.textContent = params.impresion === 'color' ? 'A color' : 'Blanco y negro';
                break;
            case 'mostrar precio':
                cell.textContent = params.precio ? 'Sí' : 'No';
                break;
            case 'texto adicional':
                cell.textContent = params.texto || 'No proporcionado';
                break;
        }
    });

    // Update total price
    const priceElement = document.querySelector('p strong');
    if (priceElement) {
        const price = calculatePrice(params.copias, params.impresion === 'color');
        priceElement.textContent = `Precio total: ${price}€`;
    }
}

// Run when the DOM is loaded
document.addEventListener('DOMContentLoaded', fillTable);