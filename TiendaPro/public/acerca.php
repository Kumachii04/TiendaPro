<?php
session_start();
require_once '../config/connection.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca de N.A.E.I Market</title>
    <link rel="shortcut icon" href="/assets/img/logo/nae.png">
    <link rel="stylesheet" href="/src/css/acerca.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include '../src/components/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-acerca">
        <div class="container">
            <h1>Acerca de N.A.E Store</h1>
            <p>Tu tienda de tecnología de confianza en Panamá. Calidad, rapidez y servicio excepcional.</p>
        </div>
    </section>

    <!-- Misión y Visión -->
    <section class="container">
        <h2 class="section-title">Nuestra Misión y Visión</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card-about">
                    <div class="card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h5>Misión</h5>
                    <p>Ofrecer productos tecnológicos de alta calidad a precios accesibles, con un enfoque en la
                        satisfacción del cliente, la innovación y la entrega rápida en todo Panamá.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card-about">
                    <div class="card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h5>Visión</h5>
                    <p>Ser la tienda de tecnología líder en Panamá, reconocida por su confiabilidad, servicio postventa
                        y compromiso con la innovación y el crecimiento sostenible.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Valores -->
    <section class="container mt-5">
        <h2 class="section-title">Nuestros Valores</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card-about text-center">
                    <div class="card-icon mx-auto">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5>Confianza</h5>
                    <p>Construimos relaciones basadas en la honestidad y transparencia.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card-about text-center">
                    <div class="card-icon mx-auto">
                        <i class="fas fa-star"></i>
                    </div>
                    <h5>Calidad</h5>
                    <p>Comprometidos con productos y servicios de excelencia.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card-about text-center">
                    <div class="card-icon mx-auto">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5>Atención</h5>
                    <p>Siempre a tu disposición para resolver tus inquietudes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Línea de tiempo -->
    <section class="container mt-5">
        <h2 class="section-title">Nuestra Historia</h2>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-content">
                    <span class="year">2020</span>
                    <h4>Fundación</h4>
                    <p>N.A.E Store nace como un pequeño emprendimiento en Ciudad de Panamá, con el sueño de
                        revolucionar la venta de tecnología.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <span class="year">2022</span>
                    <h4>Expansión</h4>
                    <p>Lanzamos nuestra tienda en línea y comenzamos a ofrecer envíos a nivel nacional.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <span class="year">2024</span>
                    <h4>Crecimiento</h4>
                    <p>Más de 5,000 clientes satisfechos y una amplia gama de productos tecnológicos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Equipo -->
    <section class="container mt-5">
        <h2 class="section-title">Nuestro Equipo</h2>
        <div class="row">
            <div class="col-md-3 col-6 mb-4">
                <div class="team-member">
                    <img src="https://i.pravatar.cc/150?img=1" alt="Abdiel Montezuma, CEO">
                    <h5>Abdiel Montezuma</h5>
                    <p>CEO & Fundador</p>
                    <div class="social-team">
                        <a href="#" aria-label="LinkedIn de Carlos"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" aria-label="Twitter de Carlos"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6 mb-4">
                <div class="team-member">
                    <img src="https://i.pravatar.cc/150?img=3" alt="Enier Arauz, Soporte Técnico">
                    <h5>Enier Arauz</h5>
                    <p>Soporte Técnico</p>
                    <div class="social-team">
                        <a href="#" aria-label="LinkedIn de Luis"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" aria-label="WhatsApp de Luis"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="team-member">
                    <img src="https://i.pravatar.cc/150?img=4" alt="Nayelis Gilbot, Logística">
                    <h5>Nayelis Gilbot</h5>
                    <p>Logística</p>
                    <div class="social-team">
                        <a href="#" aria-label="LinkedIn de María"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" aria-label="Instagram de María"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contacto final -->
    <section class="container mt-5 mb-5 text-center cta-section">
        <h2 class="section-title">¿Listo para comenzar?</h2>
        <p class="lead">Únete a miles de clientes satisfechos en N.A.E.I Market.</p>
        <a href="/public/home_product.php" class="btn">
            <i class="fas fa-shopping-cart me-2"></i>Explorar Productos
        </a>
    </section>

    <?php include '../src/components/footer.html'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>