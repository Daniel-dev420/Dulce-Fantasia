// Variables globales
let cart = [];
let selectedPaymentMethod = '';

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    initializeSlider();
    updateCartDisplay();
    setInvoiceDate();
    generateInvoiceNumber();
});

// Slider mejorado
function initializeSlider() {
    const slides = document.querySelectorAll('.slider img');
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        slides[index].classList.add('active');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    // Cambiar slide cada 4 segundos
    setInterval(nextSlide, 4000);
}

// Funciones del carrito
function addToCart(name, price, image) {
    const existingItem = cart.find(item => item.name === name);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            name: name,
            price: price,
            image: image,
            quantity: 1
        });
    }
    
    updateCartDisplay();
    showCartNotification(name);
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCartDisplay();
}

function updateQuantity(index, change) {
    cart[index].quantity += change;
    if (cart[index].quantity <= 0) {
        removeFromCart(index);
    } else {
        updateCartDisplay();
    }
}

function updateCartDisplay() {
    const cartItems = document.getElementById('cartItems');
    const cartCount = document.getElementById('cartCount');
    const cartTotal = document.getElementById('cartTotal');
    
    if (cart.length === 0) {
        cartItems.innerHTML = '<p style="text-align: center; color: var(--neutral-dark); padding: 2rem;">Tu carrito está vacío</p>';
        cartCount.textContent = '0';
        cartTotal.textContent = 'Total: $0';
        return;
    }
    
    let total = 0;
    let itemCount = 0;
    
    cartItems.innerHTML = cart.map((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        itemCount += item.quantity;
        
        return `
            <div class="cart-item">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <img src="${item.image}" alt="${item.name}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                    <div>
                        <div style="font-weight: 600; font-size: 0.9rem;">${item.name}</div>
                        <div style="color: var(--primary-color); font-weight: 600;">$${item.price.toLocaleString()}</div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <button onclick="updateQuantity(${index}, -1)" style="background: var(--primary-color); color: white; border: none; width: 25px; height: 25px; border-radius: 50%; cursor: pointer;">-</button>
                    <span style="font-weight: 600;">${item.quantity}</span>
                    <button onclick="updateQuantity(${index}, 1)" style="background: var(--primary-color); color: white; border: none; width: 25px; height: 25px; border-radius: 50%; cursor: pointer;">+</button>
                    <button onclick="removeFromCart(${index})" style="background: #dc2626; color: white; border: none; width: 25px; height: 25px; border-radius: 50%; cursor: pointer; margin-left: 0.5rem;">×</button>
                </div>
            </div>
        `;
    }).join('');
    
    cartCount.textContent = itemCount;
    cartTotal.textContent = `Total: $${total.toLocaleString()}`;
}

function toggleCart() {
    const cartFloat = document.getElementById('cartFloat');
    cartFloat.classList.toggle('open');
}

function showCartNotification(productName) {
    // Crear notificación temporal
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: var(--shadow-heavy);
        z-index: 3000;
        animation: slideInRight 0.3s ease-out;
    `;
    notification.innerHTML = `
        <div style="font-weight: 600;">¡Producto agregado!</div>
        <div style="font-size: 0.9rem; opacity: 0.9;">${productName}</div>
    `;
    
    document.body.appendChild(notification);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-in';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Funciones de facturación
function showInvoice() {
    if (cart.length === 0) {
        alert('Tu carrito está vacío. Agrega productos antes de proceder al pago.');
        return;
    }
    
    updateInvoiceDisplay();
    document.getElementById('invoiceModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeInvoice() {
    document.getElementById('invoiceModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    selectedPaymentMethod = '';
    document.querySelectorAll('.payment-method').forEach(method => {
        method.classList.remove('selected');
    });
}

function updateInvoiceDisplay() {
    const invoiceItems = document.getElementById('invoiceItems');
    const invoiceSubtotal = document.getElementById('invoiceSubtotal');
    const invoiceIVA = document.getElementById('invoiceIVA');
    const invoiceTotal = document.getElementById('invoiceTotal');
    
    let subtotal = 0;
    
    invoiceItems.innerHTML = cart.map(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        
        return `
            <tr>
                <td>${item.name}</td>
                <td>${item.quantity}</td>
                <td>$${item.price.toLocaleString()}</td>
                <td>$${itemTotal.toLocaleString()}</td>
            </tr>
        `;
    }).join('');
    
    const iva = Math.round(subtotal * 0.19);
    const total = subtotal + iva;
    
    invoiceSubtotal.textContent = subtotal.toLocaleString();
    invoiceIVA.textContent = iva.toLocaleString();
    invoiceTotal.textContent = total.toLocaleString();
}

function selectPayment(method) {
    selectedPaymentMethod = method;
    document.querySelectorAll('.payment-method').forEach(paymentMethod => {
        paymentMethod.classList.remove('selected');
    });
    event.currentTarget.classList.add('selected');
}

function confirmPayment() {
    if (!selectedPaymentMethod) {
        alert('Por favor selecciona un método de pago.');
        return;
    }
    
    // Simular procesamiento de pago
    const confirmBtn = document.querySelector('.confirm-payment-btn');
    const originalText = confirmBtn.textContent;
    
    confirmBtn.textContent = 'Procesando...';
    confirmBtn.disabled = true;
    
    setTimeout(() => {
        // Mostrar mensaje de éxito
        showPaymentSuccess();
        
        // Limpiar carrito
        cart = [];
        updateCartDisplay();
        
        // Cerrar modal
        closeInvoice();
        
        // Restaurar botón
        confirmBtn.textContent = originalText;
        confirmBtn.disabled = false;
    }, 2000);
}

function showPaymentSuccess() {
    const successModal = document.createElement('div');
    successModal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 4000;
    `;
    
    successModal.innerHTML = `
        <div style="
            background: white;
            padding: 3rem;
            border-radius: 16px;
            text-align: center;
            max-width: 400px;
            box-shadow: var(--shadow-heavy);
            animation: fadeInUp 0.3s ease-out;
        ">
            <div style="font-size: 4rem; color: #10b981; margin-bottom: 1rem;">✓</div>
            <h3 style="color: var(--primary-color); margin-bottom: 1rem;">¡Pago Exitoso!</h3>
            <p style="color: var(--neutral-dark); margin-bottom: 2rem;">
                Tu pedido ha sido procesado correctamente. 
                Recibirás un correo de confirmación en breve.
            </p>
            <p style="font-size: 0.9rem; color: var(--neutral-dark); margin-bottom: 2rem;">
                Método de pago: <strong>${getPaymentMethodName(selectedPaymentMethod)}</strong>
            </p>
            <button onclick="document.body.removeChild(this.closest('div').parentElement)" 
                    style="
                        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
                        color: white;
                        border: none;
                        padding: 0.75rem 2rem;
                        border-radius: 25px;
                        font-weight: 600;
                        cursor: pointer;
                        transition: var(--transition);
                    ">
                Continuar Comprando
            </button>
        </div>
    `;
    
    document.body.appendChild(successModal);
}

function getPaymentMethodName(method) {
    const methods = {
        'daviplata': 'Daviplata',
        'nequi': 'Nequi',
        'tarjeta': 'Tarjeta de Crédito/Débito',
        'efectivo': 'Efectivo'
    };
    return methods[method] || method;
}

function setInvoiceDate() {
    const now = new Date();
    const dateString = now.toLocaleDateString('es-CO', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    document.getElementById('invoiceDate').textContent = dateString;
}

function generateInvoiceNumber() {
    const number = Math.floor(Math.random() * 9000) + 1000;
    document.getElementById('invoiceNumber').textContent = number.toString().padStart(6, '0');
}

// Función para scroll suave al top
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Scroll suave para enlaces internos
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Animaciones al hacer scroll
function handleScrollAnimations() {
    const elements = document.querySelectorAll('.fade-in-up');
    elements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < window.innerHeight - elementVisible) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
}

// Inicializar animaciones de scroll
document.addEventListener('scroll', handleScrollAnimations);

// Cerrar modal al hacer clic fuera
window.addEventListener('click', function(event) {
    const modal = document.getElementById('invoiceModal');
    if (event.target === modal) {
        closeInvoice();
    }
});

// Agregar estilos de animación dinámicamente
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease-out;
    }
`;
document.head.appendChild(style);

