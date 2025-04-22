<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruleta de la Suerte</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }

        .ruleta-container {
            text-align: center;
        }

        canvas {
            border: 10px solid #333;
            border-radius: 50%;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #555;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            position: relative;
            max-width: 90%;
            width: 300px;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        #resultado {
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="ruleta-container">
        <canvas id="ruleta" width="500" height="500"></canvas>
        <button id="girar">Girar</button>
        <div id="resultado"></div>
    </div>

    <div class="modal" id="resultadoModal">
        <div class="modal-content">
            <button class="close-btn" id="closeModal">&times;</button>
            <h2 id="resultadoTexto"></h2>
            <img id="resultadoImagen" src="" alt="Imagen del resultado" style="max-width: 100%; height: auto; margin-top: 10px;">
            <p>¡Gracias por participar!</p>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('ruleta');
        const ctx = canvas.getContext('2d');
        const botonGirar = document.getElementById('girar');
        const resultadoModal = document.getElementById('resultadoModal');
        const resultadoTexto = document.getElementById('resultadoTexto');
        const resultadoImagen = document.getElementById('resultadoImagen');
        const closeModal = document.getElementById('closeModal');

        const opciones = [{
                texto: 'Vuelve a intentarlo',
                imagen: 'https://via.placeholder.com/200?text=Intentalo+de+nuevo',
                probabilidad: 0.2
            },
            {
                texto: 'Vuelve a intentarlo',
                imagen: 'https://via.placeholder.com/200?text=Intentalo+de+nuevo',
                probabilidad: 0.2
            },
            {
                texto: 'Ganaste una cosmetiquera',
                imagen: 'https://elemental.aricrm.co/img/cosmetiquera.jpg',
                probabilidad: 0.13
            },
            {
                texto: 'Ganaste una cosmetiquera',
                imagen: 'https://elemental.aricrm.co/img/cosmetiquera.jpg',
                probabilidad: 0.13
            },
            {
                texto: 'Ganaste una Cartuchera',
                imagen: 'https://elemental.aricrm.co/img/cartuchera.jpg',
                probabilidad: 0.13
            },
            {
                texto: 'Ganaste una Cartuchera',
                imagen: 'https://elemental.aricrm.co/img/cartuchera.jpg',
                probabilidad: 0.13
            },
            {
                texto: 'Ganaste producto',
                imagen: 'https://elemental.aricrm.co/img/producto.jpg',
                probabilidad: 0.08
            }
        ];



        const colores = [
            '#F7F8FA', '#ffe5ef', '#F7F8FA', '#ffe5ef', '#F7F8FA', '#ffe5ef', '#F7F8FA'
        ];

        function dibujarRuleta() {
            const cantidad = opciones.length;
            const anguloPorOpcion = 2 * Math.PI / cantidad;

            for (let i = 0; i < cantidad; i++) {
                const anguloInicio = i * anguloPorOpcion;
                const anguloFinal = (i + 1) * anguloPorOpcion;

                ctx.beginPath();
                ctx.moveTo(250, 250);
                ctx.arc(250, 250, 250, anguloInicio, anguloFinal);
                ctx.fillStyle = colores[i % colores.length];
                ctx.fill();
                ctx.strokeStyle = '#333';
                ctx.lineWidth = 2;
                ctx.stroke();

                ctx.save();
                ctx.translate(250, 250);
                ctx.rotate((anguloInicio + anguloFinal) / 2);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillStyle = '#000';
                ctx.font = 'bold 18px Arial';
                ctx.shadowColor = 'rgba(0, 0, 0, 0.5)';
                ctx.shadowBlur = 4;
                ctx.shadowOffsetX = 2;
                ctx.shadowOffsetY = 2;

                const texto = opciones[i].texto;
                const lineHeight = 24;
                const maxWidth = 100;
                const lines = wrapText(ctx, texto, maxWidth);
                lines.forEach((line, index) => {
                    ctx.fillText(line, 125, index * lineHeight - (lines.length - 1) * lineHeight / 2);
                });
                ctx.restore();
            }
        }

        function wrapText(context, text, maxWidth) {
            const words = text.split(' ');
            let lines = [];
            let currentLine = words[0];

            for (let i = 1; i < words.length; i++) {
                const word = words[i];
                const width = context.measureText(currentLine + ' ' + word).width;
                if (width < maxWidth) {
                    currentLine += ' ' + word;
                } else {
                    lines.push(currentLine);
                    currentLine = word;
                }
            }
            lines.push(currentLine);
            return lines;
        }

        let anguloActual = 0;

        function girarRuleta() {
            const velocidad = Math.random() * 4 + 6;
            let anguloDestino = anguloActual + velocidad * 2 * Math.PI;

            let intervalo = setInterval(() => {
                anguloActual += 0.1;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.save();
                ctx.translate(250, 250);
                ctx.rotate(anguloActual);
                ctx.translate(-250, -250);
                dibujarRuleta();
                ctx.restore();

                if (anguloActual >= anguloDestino) {
                    clearInterval(intervalo);
                    mostrarResultado();
                }
            }, 16);
        }

        function mostrarResultado() {
            const totalProbabilidad = opciones.reduce((acc, opcion) => acc + opcion.probabilidad, 0);
            const random = Math.random() * totalProbabilidad;
            let acumulado = 0;
            let resultadoSeleccionado = null;

            for (let i = 0; i < opciones.length; i++) {
                acumulado += opciones[i].probabilidad;
                if (random <= acumulado) {
                    resultadoSeleccionado = opciones[i];
                    break;
                }
            }

            resultadoTexto.textContent = `${resultadoSeleccionado.texto}`;
            resultadoImagen.src = resultadoSeleccionado.imagen;
            resultadoModal.style.display = 'flex';
        }

        closeModal.addEventListener('click', () => {
            resultadoModal.style.display = 'none';
        });

        botonGirar.addEventListener('click', girarRuleta);

        dibujarRuleta();
    </script>

</body>

</html>