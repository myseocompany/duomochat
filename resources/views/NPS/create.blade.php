@extends('api')

@section('content')

<div class="all-content">
    <div class="info-container">
        <span class="mensaje">
            <b style="font-size: 1.2em;">Por favor, califica del 0 al 10 qué tan probable es que nos recomiendes a tus amigos, familiares o conocidos.</b>
        </span>
    
        <div class="survey-container">
        @if(isset($model))    
        <form method="POST" action="/metadata/{{$model->id}}/store/nps" class="radio-tile-group">
            {{ csrf_field() }}
    
            <div class="radio-tiles-wrapper">
                @for($i = 1; $i <= 10; $i++)
                    <div class="input-container">
                        <input id="option{{$i}}" class="radio-button" type="radio" name="nps" value="{{$i}}">
                        <div class="radio-tile" data-value="{{$i}}">
                            <div class="icon @if($i <= 6) icon-bg-red @elseif($i <= 8) icon-bg-blue @else icon-bg-green @endif">
                                @if($i >0 && $i <= 2)
                                    <!-- emoji enojado -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-emoji-angry" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.5 3.5 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.5 4.5 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683m6.991-8.38a.5.5 0 1 1 .448.894l-1.009.504c.176.27.285.64.285 1.049 0 .828-.448 1.5-1 1.5s-1-.672-1-1.5c0-.247.04-.48.11-.686a.502.502 0 0 1 .166-.761zm-6.552 0a.5.5 0 0 0-.448.894l1.009.504A1.94 1.94 0 0 0 5 6.5C5 7.328 5.448 8 6 8s1-.672 1-1.5c0-.247-.04-.48-.11-.686a.502.502 0 0 0-.166-.761z"/>
                                    </svg>
                                @elseif($i > 2 && $i <= 4)
                                    <!-- emoji super triste -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-emoji-tear" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M6.831 11.43A3.1 3.1 0 0 1 8 11.196c.916 0 1.607.408 2.25.826.212.138.424-.069.282-.277-.564-.83-1.558-2.049-2.532-2.049-.53 0-1.066.361-1.536.824q.126.27.232.535.069.174.135.373ZM6 11.333C6 12.253 5.328 13 4.5 13S3 12.254 3 11.333c0-.706.882-2.29 1.294-2.99a.238.238 0 0 1 .412 0c.412.7 1.294 2.284 1.294 2.99M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5m-1.5-3A.5.5 0 0 1 10 3c1.162 0 2.35.584 2.947 1.776a.5.5 0 1 1-.894.448C11.649 4.416 10.838 4 10 4a.5.5 0 0 1-.5-.5M7 3.5a.5.5 0 0 0-.5-.5c-1.162 0-2.35.584-2.947 1.776a.5.5 0 1 0 .894.448C4.851 4.416 5.662 4 6.5 4a.5.5 0 0 0 .5-.5"/>
                                    </svg>
                                @elseif($i > 4 && $i <= 6)
                                    <!-- Emoji triste -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#ff6b6b" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.5 3.5 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.5 4.5 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5"/>
                                    </svg>
                                @elseif($i == 7)
                                    <!-- emoji poco serio -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-emoji-grimace" viewBox="0 0 16 16">
                                        <path d="M7 6.25c0 .69-.448 1.25-1 1.25s-1-.56-1-1.25S5.448 5 6 5s1 .56 1 1.25m3 1.25c.552 0 1-.56 1-1.25S10.552 5 10 5s-1 .56-1 1.25.448 1.25 1 1.25m2.98 3.25A1.5 1.5 0 0 1 11.5 12h-7a1.5 1.5 0 0 1-1.48-1.747v-.003A1.5 1.5 0 0 1 4.5 9h7a1.5 1.5 0 0 1 1.48 1.747zm-8.48.75h.25v-.75H3.531a1 1 0 0 0 .969.75m7 0a1 1 0 0 0 .969-.75H11.25v.75zm.969-1.25a1 1 0 0 0-.969-.75h-.25v.75zM4.5 9.5a1 1 0 0 0-.969.75H4.75V9.5zm1.75 2v-.75h-1v.75zm.5 0h1v-.75h-1zm1.5 0h1v-.75h-1zm1.5 0h1v-.75h-1zm1-2h-1v.75h1zm-1.5 0h-1v.75h1zm-1.5 0h-1v.75h1zm-1.5 0h-1v.75h1z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m0-1A7 7 0 1 1 8 1a7 7 0 0 1 0 14"/>
                                    </svg>
                                @elseif($i <= 8)
                                    <!-- Emoji neutral -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#6bc3ff" class="bi bi-emoji-neutral" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M4 10.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5m3-4C7 5.672 6.552 5 6 5s-1 .672-1 1.5S5.448 8 6 8s1-.672 1-1.5m4 0c0-.828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5"/>
                                    </svg>
                                @elseif($i == 9)
                                    <!-- Emoji feliz -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#51d88a" class="bi bi-emoji-smile" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5"/>
                                    </svg>
                                @else
                                    <!-- emoji enamorado -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-heart-eyes" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M11.315 10.014a.5.5 0 0 1 .548.736A4.5 4.5 0 0 1 7.965 13a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .548-.736h.005l.017.005.067.015.252.055c.215.046.515.108.857.169.693.124 1.522.242 2.152.242s1.46-.118 2.152-.242a27 27 0 0 0 1.109-.224l.067-.015.017-.004.005-.002zM4.756 4.566c.763-1.424 4.02-.12.952 3.434-4.496-1.596-2.35-4.298-.952-3.434m6.488 0c1.398-.864 3.544 1.838-.952 3.434-3.067-3.554.19-4.858.952-3.434"/>
                                    </svg>
                                @endif
                            </div>
                        </div>
                        <label for="option{{$i}}" class="radio-tile-label">{{$i}}</label>
                    </div>
                @endfor
            </div>
            <div class="submit-btn-wrapper">
                <button type="submit" class="submit-btn">Guardar</button>
            </div>
        </form>
        @else
            <p>El número no fue encontrado en la base de datos.</p>
        @endif
        </div>
    
    </div>
    
    
    <div class="logo-container"></div>
    <div class="span">
        <span>{{$model->name}} gracias por ayudarnos a mejorar. Esta breve encuesta nos permitirá conocer tu opinión y mejorar nuestra calidad de servicio.</span>
    </div>
</div>

<style>
    * {
        box-sizing: border-box;
        font-family: 'Helvetica Neue', sans-serif;
    }
    .all-content{
        width: 100%;
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .span{
        margin-top: 20px;
        width: 100%;
        height: 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .icon-bg-red {
        display: flex;
        width: 15px;
        height: 15px;
        background-color: #fb6368;
        border-radius: 50%;
    }

    .icon-bg-blue {
        display: flex;
        width: 15px;
        height: 15px;
        background-color: #00B5B0;
        border-radius: 50%;
    }

    .icon-bg-green {
        display: flex;
        width: 15px;
        height: 15px;
        background-color: #6FC828;
        border-radius: 50%;
    }


    body {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 40px;
        background-color: #fff;
    }

    .info-container{
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        background: whitesmoke;
    }

    .survey-container {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-top: 30px; /* Margen adicional */
        padding-bottom: 20px;
    }

    .radio-tiles-wrapper {
        display: flex;
        justify-content: center;
    }

    .input-container {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .radio-button {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        cursor: pointer;
    }

    .radio-tile {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 30px; /* Tamaño del contenedor */
        height: 30px; /* Tamaño del contenedor */
        border: none; /* Sin borde inicialmente */
        border-radius: 50%; /* Redondeado */
        background-color: transparent; /* Fondo transparente inicialmente */
        transition: transform 200ms ease, background-color 200ms ease, border-color 200ms ease;
    }

    /* Colores de borde por defecto */
    .radio-tile[data-value="1"],
    .radio-tile[data-value="2"],
    .radio-tile[data-value="3"],
    .radio-tile[data-value="4"],
    .radio-tile[data-value="5"],
    .radio-tile[data-value="6"] {
        border: 2px solid transparent;
    }

    .radio-tile[data-value="7"],
    .radio-tile[data-value="8"] {
        border: 2px solid transparent;
    }

    .radio-tile[data-value="9"],
    .radio-tile[data-value="10"] {
        border: 2px solid transparent;
    }

    /* Colores al seleccionarse */
    .radio-button:checked + .radio-tile {
        transform: scale(1.3);
        margin-bottom: 10px;
        border: 1px solid gainsboro; /* Borde blanco */
    }

    .radio-button:checked + .radio-tile[data-value="1"],
    .radio-button:checked + .radio-tile[data-value="2"],
    .radio-button:checked + .radio-tile[data-value="3"],
    .radio-button:checked + .radio-tile[data-value="4"],
    .radio-button:checked + .radio-tile[data-value="5"],
    .radio-button:checked + .radio-tile[data-value="6"] {
        background-color: #fb6368;
    }

    .radio-button:checked + .radio-tile[data-value="7"],
    .radio-button:checked + .radio-tile[data-value="8"] {
        background-color: #00B5B0;
    }

    .radio-button:checked + .radio-tile[data-value="9"],
    .radio-button:checked + .radio-tile[data-value="10"] {
        background-color: #6FC828;
    }

    .icon svg {
        fill: black;
        width: 15px;
        height: 15px;
        transition: fill 200ms ease;
    }


    .radio-tile-label {
        margin-top: 5px;
        font-size: 12px; /* Tamaño reducido */
        color: inherit;
    }

    .radio-button:checked + .radio-tile .icon svg {
       fill: inherit; /* Mantiene el color definido según el rango */
    }

    .submit-btn-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .submit-btn {
        padding: 5px 20px;
        border: none;
        border-radius: 5px;
        background-color: black;
        color: white;
        font-size: 10px;
        cursor: pointer;
    }

    .submit-btn:hover {
        background-color: #333;
    }

    .mensaje {
        width: 100%;
        height: auto; 
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        word-wrap: break-word; 
        overflow-wrap: break-word; 
        margin-top: 30px;
        padding: 10px; 
    }

    .name-container{
        width: 100%;
        height: 60px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }
    .logo-container{
        width: 100%;
        height: 100px;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        margin-top: 20px;
        margin-bottom: 20px;
        background-image: url('data:image/png;base64,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');
    }

@media (max-width: 768px) {
        .mensaje b {
        font-size: 1rem; 
        }

        .mensaje {
            font-size: 0.9rem; 
            padding: 5px; 
        }
        .info-container {
            background-color: white;
        }

        /* Estilo base sin borde para todos los emojis */
        .radio-tile {
            width: 20px;
            height: 20px;
            border: 2px solid transparent; /* Sin borde por defecto */
            transition: border 0.2s ease-in-out, background-color 0.2s ease-in-out;
        }

        .radio-tiles-wrapper {
            gap: 15px;
        }
        .icon-bg-red, .icon-bg-blue, .icon-bg-green, .icon svg{
            width: 30px;
            height: 30px;
        }
        
}

@media (min-width: 1200px) {
    .radio-tile {
        width: 50px;
        height: 50px;
        border: 2px solid transparent; /* Sin borde por defecto */
        display: flex;
        align-items: center;
        justify-content: center;
        transition: border 0.2s ease-in-out, background-color 0.2s ease-in-out;
    }

    .radio-tiles-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px; /* Ajustado para mantener mejor alineación */
    }

    /* ✅ Solo el emoji seleccionado tendrá borde y color */
    .radio-button:checked + .radio-tile {
        border: 4px solid currentColor; /* El borde toma el color del texto actual */
    }

    /* ✅ Corrección del tamaño de los íconos en PC */
    .icon-bg-red, .icon-bg-blue, .icon-bg-green, .icon svg {
        width: 30px;
        height: 30px;
    }

    /* ✅ Color de fondo y borde solo en el seleccionado */
    .radio-button:checked + .radio-tile[data-value="1"],
    .radio-button:checked + .radio-tile[data-value="2"],
    .radio-button:checked + .radio-tile[data-value="3"],
    .radio-button:checked + .radio-tile[data-value="4"],
    .radio-button:checked + .radio-tile[data-value="5"],
    .radio-button:checked + .radio-tile[data-value="6"] {
        background-color: #fb6368;
        border-color: #d32f2f;
    }

    .radio-button:checked + .radio-tile[data-value="7"],
    .radio-button:checked + .radio-tile[data-value="8"] {
        background-color: #00B5B0;
        border-color: #008b8b;
    }

    .radio-button:checked + .radio-tile[data-value="9"],
    .radio-button:checked + .radio-tile[data-value="10"] {
        background-color: #6FC828;
        border-color: #4CAF50;
    }
}





</style>

<script>
    document.title = "Encuesta NPS";
</script>

@endsection
