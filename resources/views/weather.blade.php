<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima - Laravel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
            transition: background 1s ease;
        }

        body.day {
            background: linear-gradient(135deg, #00b4db, #0083b0);
        }

        body.night {
            background: linear-gradient(135deg, #1a237e, #000051);
        }

        .weather-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .stars {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkle 1.5s infinite ease-in-out;
            display: none;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .moon {
            position: absolute;
            width: 60px;
            height: 60px;
            background: #ffffff;
            border-radius: 50%;
            box-shadow: inset -20px -20px 0 #b9b9b9;
            display: none;
            animation: moonGlow 4s infinite ease-in-out;
        }

        @keyframes moonGlow {
            0%, 100% { box-shadow: inset -20px -20px 0 #b9b9b9, 0 0 20px rgba(255,255,255,0.5); }
            50% { box-shadow: inset -20px -20px 0 #b9b9b9, 0 0 30px rgba(255,255,255,0.8); }
        }

        .rain {
            position: absolute;
            width: 2px;
            height: 100px;
            background: linear-gradient(transparent, rgba(255,255,255,0.8));
            animation: rain 1s linear infinite;
            display: none;
        }

        .cloud {
            position: absolute;
            width: 100px;
            height: 40px;
            background: rgba(255,255,255,0.8);
            border-radius: 20px;
            animation: float 6s ease-in-out infinite;
            display: none;
        }

        .sun {
            position: absolute;
            width: 80px;
            height: 80px;
            background: #FFD700;
            border-radius: 50%;
            box-shadow: 0 0 50px #FFD700;
            animation: glow 3s ease-in-out infinite;
            display: none;
        }

        @keyframes rain {
            0% { transform: translateY(-100px); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(100vh); opacity: 0; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 0 50px #FFD700; }
            50% { box-shadow: 0 0 80px #FFD700; }
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 1;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.5s ease forwards;
        }

        .night .container {
            background: rgba(255, 255, 255, 0.8);
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .night h1 {
            color: #1a237e;
        }

        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex: 1;
            padding: 15px;
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.9);
        }

        input[type="text"]:focus {
            border-color: #0083b0;
            box-shadow: 0 0 15px rgba(0,131,176,0.2);
            transform: scale(1.02);
        }

        .night input[type="text"]:focus {
            border-color: #1a237e;
            box-shadow: 0 0 15px rgba(26,35,126,0.2);
        }

        button {
            background: #0083b0;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .night button {
            background: #1a237e;
        }

        button:hover {
            background: #006d94;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .night button:hover {
            background: #000051;
        }

        button:active {
            transform: translateY(0);
        }

        .error {
            background: #ffe6e6;
            border-left: 4px solid #ff4444;
            color: #cc0000;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .weather-info {
            background: rgba(248,249,250,0.9);
            border-radius: 15px;
            padding: 25px;
            transform: scale(0.95);
            opacity: 0;
            animation: popIn 0.5s ease forwards;
        }

        .night .weather-info {
            background: rgba(248,249,250,0.8);
        }

        @keyframes popIn {
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .city-name {
            font-size: 28px;
            color: #333;
            margin-bottom: 25px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .night .city-name {
            color: #1a237e;
        }

        .weather-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .weather-item {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .weather-item:hover {
            transform: translateY(-5px);
        }

        .weather-label {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .weather-value {
            color: #0083b0;
            font-size: 26px;
            font-weight: bold;
        }

        .night .weather-value {
            color: #1a237e;
        }

        .period-indicator {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            color: white;
        }

        .period-indicator.day {
            background: #FFD700;
            color: #333;
        }

        .period-indicator.night {
            background: #1a237e;
            color: white;
        }
    </style>
</head>
<body class="{{ $isDay ?? true ? 'day' : 'night' }}">
    <div class="weather-background">
        <div class="rain"></div>
        <div class="cloud"></div>
        <div class="sun"></div>
        <div class="moon"></div>
        <div class="stars"></div>
    </div>

    <div class="container">
        <h1>Consulta de Clima</h1>
        
        <form method="POST" action="/search" class="search-form">
            @csrf
            <input type="text" name="city" placeholder="Digite o nome da cidade" required>
            <button type="submit">Buscar</button>
        </form>

        @isset($error)
            <div class="error">
                <p>{{ $error }}</p>
            </div>
        @endisset

        @isset($weatherData)
            <div class="weather-info">
                <span class="period-indicator {{ $isDay ? 'day' : 'night' }}">
                    {{ $isDay ? 'Dia' : 'Noite' }}
                </span>
                <h2 class="city-name">{{ $city }}</h2>
                
                <div class="weather-grid">
                    <div class="weather-item">
                        <p class="weather-label">Temperatura</p>
                        <p class="weather-value">{{ $weatherData['main']['temp'] }}°C</p>
                    </div>
                    
                    <div class="weather-item">
                        <p class="weather-label">Umidade</p>
                        <p class="weather-value">{{ $weatherData['main']['humidity'] }}%</p>
                    </div>
                    
                    <div class="weather-item">
                        <p class="weather-label">Clima</p>
                        <p class="weather-value" style="font-size: 20px;">{{ ucfirst($weatherData['weather'][0]['description']) }}</p>
                    </div>
                    
                    <div class="weather-item">
                        <p class="weather-label">Vento</p>
                        <p class="weather-value">{{ number_format($weatherData['wind']['speed'] * 3.6, 1) }} km/h</p>
                    </div>
                </div>
            </div>

            <audio id="weatherSound" loop>
                <source src="" type="audio/mpeg">
            </audio>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const weatherDescription = "{{ $weatherData['weather'][0]['main'] }}".toLowerCase();
                    const isDay = {{ $isDay ? 'true' : 'false' }};
                    const weatherBackground = document.querySelector('.weather-background');
                    const rain = document.querySelector('.rain');
                    const cloud = document.querySelector('.cloud');
                    const sun = document.querySelector('.sun');
                    const moon = document.querySelector('.moon');
                    const stars = document.querySelector('.stars');
                    const audio = document.getElementById('weatherSound');

                    // Clear previous effects
                    rain.style.display = 'none';
                    cloud.style.display = 'none';
                    sun.style.display = 'none';
                    moon.style.display = 'none';
                    const existingStars = weatherBackground.querySelectorAll('.stars');
                    existingStars.forEach(star => star.remove());
                    audio.pause();

                    if (!isDay) {
                        // Create stars for night time
                        for (let i = 0; i < 100; i++) {
                            const star = document.createElement('div');
                            star.className = 'stars';
                            star.style.display = 'block';
                            star.style.left = Math.random() * 100 + '%';
                            star.style.top = Math.random() * 100 + '%';
                            star.style.animationDelay = Math.random() * 2 + 's';
                            weatherBackground.appendChild(star);
                        }
                        moon.style.display = 'block';
                        moon.style.left = '70%';
                        moon.style.top = '20%';
                    }

                    if (weatherDescription.includes('rain')) {
                        // Create multiple raindrops
                        for (let i = 0; i < 50; i++) {
                            const raindrop = rain.cloneNode(true);
                            raindrop.style.display = 'block';
                            raindrop.style.left = Math.random() * 100 + '%';
                            raindrop.style.animationDelay = Math.random() * 2 + 's';
                            weatherBackground.appendChild(raindrop);
                        }
                        audio.src = 'https://assets.mixkit.co/active_storage/sfx/2515/2515.wav';
                    } else if (weatherDescription.includes('cloud')) {
                        // Create multiple clouds
                        for (let i = 0; i < 5; i++) {
                            const cloudElement = cloud.cloneNode(true);
                            cloudElement.style.display = 'block';
                            cloudElement.style.left = (i * 25) + '%';
                            cloudElement.style.top = (Math.random() * 50) + '%';
                            cloudElement.style.animationDelay = (i * 0.5) + 's';
                            weatherBackground.appendChild(cloudElement);
                        }
                    } else if (weatherDescription.includes('clear')) {
                        if (isDay) {
                            sun.style.display = 'block';
                            sun.style.left = '70%';
                            sun.style.top = '20%';
                            audio.src = 'https://assets.mixkit.co/active_storage/sfx/2516/2516.wav';
                        }
                    }

                    // Play weather sound
                    if (audio.src) {
                        audio.volume = 0.3;
                        audio.play();
                    }
                });
            </script>
        @endisset
    </div>
</body>
</html>