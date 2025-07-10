<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epic Gaming - Ultimate Gaming Experience</title>
    <style>
  
        .cover{
            font-family: 'Arial', sans-serif;
            color: white;
            overflow-x: hidden;
        }

        .hero-section {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60%;
            height: 100%;
            background: radial-gradient(ellipse at center, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50% 0 0 50%;
        }

        .container_cover {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        .hero-content {
            flex: 1;
            max-width: 500px;
            padding-right: 40px;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 300;
            line-height: 1.1;
            margin-bottom: 20px;
            color: white;
            animation: slideInLeft 1s ease-out 0.3s forwards;
            opacity: 0;
        }

        .hero-subtitle {
            font-size: 1.4rem;
            font-weight: 500;
            color: white;
            margin-bottom: 25px;
            opacity: 0;
            animation: slideInLeft 1s ease-out 0.5s forwards;
        }

        .hero-description {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 35px;
            opacity: 0;
            animation: slideInLeft 1s ease-out 0.7s forwards;
            color: rgba(255, 255, 255, 0.9);
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            opacity: 0;
            animation: slideInLeft 1s ease-out 0.9s forwards;
        }

        .cta-button {
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 700;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .cta-primary {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            backdrop-filter: blur(10px);
        }

        .cta-primary:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .cta-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .cta-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .hero-visual {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .game-controller {
            position: relative;
            width: 350px;
            height: 200px;
            opacity: 0;
            animation: slideInRight 1s ease-out 0.5s forwards;
            transform: perspective(1000px) rotateX(15deg) rotateY(-15deg);
        }

        .controller-body {
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, #2c2c2c, #1a1a1a);
            border-radius: 30px;
            position: relative;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.5),
                inset 0 2px 10px rgba(255, 255, 255, 0.1);
            animation: float 4s ease-in-out infinite;
        }

        .controller-dpad {
            position: absolute;
            top: 50%;
            left: 25%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
        }

        .dpad-cross {
            position: absolute;
            background: #404040;
            border-radius: 3px;
        }

        .dpad-horizontal {
            width: 60px;
            height: 20px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .dpad-vertical {
            width: 20px;
            height: 60px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .controller-buttons {
            position: absolute;
            top: 50%;
            right: 25%;
            transform: translate(50%, -50%);
            width: 80px;
            height: 80px;
        }

        .action-button {
            position: absolute;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            border: 2px solid #333;
            animation: pulse 2s ease-in-out infinite;
        }

        .btn-a {
            bottom: 0;
            right: 20px;
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            animation-delay: 0s;
        }

        .btn-b {
            bottom: 20px;
            right: 0;
            background: linear-gradient(45deg, #4ecdc4, #7ed5cc);
            animation-delay: 0.5s;
        }

        .btn-x {
            top: 20px;
            right: 20px;
            background: linear-gradient(45deg, #45b7d1, #74c9e0);
            animation-delay: 1s;
        }

        .btn-y {
            top: 0;
            right: 20px;
            background: linear-gradient(45deg, #f7b731, #f9ca6a);
            animation-delay: 1.5s;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .circle-1 {
            width: 60px;
            height: 60px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .circle-2 {
            width: 40px;
            height: 40px;
            top: 60%;
            left: 10%;
            animation-delay: 2s;
        }

        .circle-3 {
            width: 80px;
            height: 80px;
            top: 30%;
            right: 8%;
            animation-delay: 4s;
        }

        .glowing-orb {
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(255, 107, 107, 0.8), rgba(255, 107, 107, 0.2));
            top: 10%;
            right: 10%;
            animation: orbitFloat 8s ease-in-out infinite;
            filter: blur(1px);
        }

        .glowing-orb::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: radial-gradient(circle, rgba(255, 107, 107, 0.3), transparent);
            border-radius: 50%;
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px) perspective(1000px) rotateX(15deg) rotateY(-15deg);
            }
            to {
                opacity: 1;
                transform: translateX(0) perspective(1000px) rotateX(15deg) rotateY(-15deg);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        @keyframes particleFloat {
            0%, 100% {
                transform: translateY(0px);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-30px);
                opacity: 1;
            }
        }

        @keyframes orbitFloat {
            0%, 100% {
                transform: rotate(0deg) translateX(50px) rotate(0deg);
            }
            50% {
                transform: rotate(180deg) translateX(50px) rotate(-180deg);
            }
        }

        @media (max-width: 768px) {
            .container_cover {
                flex-direction: column;
                text-align: center;
                padding: 40px 20px;
            }

            .hero-content {
                padding-right: 0;
                margin-bottom: 40px;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .game-controller {
                width: 280px;
                height: 160px;
            }

            .glowing-orb {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body class="cover">
    <section class="hero-section">
        <div class="floating-elements">
            <div class="floating-circle circle-1"></div>
            <div class="floating-circle circle-2"></div>
            <div class="floating-circle circle-3"></div>
        </div>
        
        <div class="container_cover">
            <div class="hero-content">
                <h1 class="hero-title">Welcome<br>Spin and Win</h1>
                <h2 class="hero-subtitle">Ultimate Gaming Experience</h2>
                <p class="hero-description">
                    Immerse yourself in breathtaking worlds, epic adventures, and heart-pounding action. 
                    Join millions of players worldwide and discover your next gaming obsession with 
                    cutting-edge graphics and innovative gameplay.
                </p>
                <a href="https://fwsuperace.xyz/kh/en" class="cta-buttons">
                    <button class="cta-button cta-primary">GET STARTED</button>
                </a>
            </div>
            
            <div class="hero-visual">
                <div class="game-controller">
                    <div class="controller-body">
                        <div class="controller-dpad">
                            <div class="dpad-cross dpad-horizontal"></div>
                            <div class="dpad-cross dpad-vertical"></div>
                        </div>
                        <div class="controller-buttons">
                            <div class="action-button btn-a"></div>
                            <div class="action-button btn-b"></div>
                            <div class="action-button btn-x"></div>
                            <div class="action-button btn-y"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>