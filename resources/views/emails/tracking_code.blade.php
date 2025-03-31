<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização do Seu Pedido</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: #333333;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .email-header {
            background: #ffffff;
            padding: 30px;
            text-align: center;
            color: white;
        }
        .email-header img {
            max-width: 120px;
            margin-bottom: 15px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
            color: #0056d2;
        }
        .email-body {
            padding: 30px;
        }
        .tracking-card {
            background-color: #f8fafc;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
            border-left: 4px solid #0056d2;
        }
        .tracking-code {
            background-color: #f0f7ff;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
            color: #0056d2;
            border: 1px dashed #0056d2;
        }
        .cta-button {
            display: block;
            text-align: center;
            margin: 30px auto;
            background: #0056d2;
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 14px 30px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            max-width: 250px;
            box-shadow: 0 4px 6px rgba(0, 86, 210, 0.1);
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 86, 210, 0.15);
        }
        .journey-container {
            margin: 30px 0;
            position: relative;
        }
        .journey-step {
            display: flex;
            margin-bottom: 20px;
            position: relative;
        }
        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e6f0ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            color: #0056d2;
            font-weight: bold;
            border: 2px solid #0056d2;
        }
        .step-content {
            flex-grow: 1;
            padding-bottom: 20px;
            border-left: 2px solid #e0e4e8;
            padding-left: 20px;
            position: relative;
        }
        .step-content:before {
            content: '';
            position: absolute;
            left: -6px;
            top: 0;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #e0e4e8;
        }
        .step-title {
            font-weight: 600;
            color: #0056d2;
            margin-bottom: 5px;
            font-size: 16px;
        }
        .step-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        .step-location {
            font-size: 13px;
            color: #888;
            margin-bottom: 5px;
            font-style: italic;
        }
        .step-date {
            font-size: 12px;
            color: #888;
        }
        .current-step .step-icon {
            background-color: #0056d2;
            color: white;
        }
        .completed-step .step-icon {
            background-color: #2bc866;
            color: white;
            border-color: #2bc866;
        }
        .completed-step .step-content:before {
            background-color: #2bc866;
        }
        .current-step .step-content:before {
            background-color: #0056d2;
            width: 12px;
            height: 12px;
            left: -7px;
            top: -1px;
        }
        .email-footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #777777;
            border-top: 1px solid #e0e4e8;
        }
        .email-footer a {
            color: #0056d2;
            text-decoration: none;
            font-weight: 500;
        }
        @media screen and (max-width: 600px) {
            .email-container {
                margin: 15px;
                border-radius: 8px;
            }
            .email-header, .email-body {
                padding: 20px;
            }
            .step-icon {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }
            .cta-button {
                width: 100%;
                padding: 12px;
            }
        }

        .step-icon img {
        width: 24px;
        height: 24px;
        filter: brightness(0) invert(1); /* Torna o ícone branco */
        object-fit: contain;
    }

    .current-step .step-icon {
        background-color: #0056d2;
        border-color: #0056d2;
    }

    .completed-step .step-icon {
        background-color: #2bc866;
        border-color: #2bc866;
        color: white;
    }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <img src="https://melhorrastreio.com.br/mr-logo.svg" alt="Logo Melhor Rastreio">
            <h1>Atualização do Seu Pedido</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Olá, {{ $name }}!</h2>
            <p>Seu pedido teve uma atualização:</p>

            <div class="tracking-card">
                <div class="tracking-code">{{ $trackingCode }}</div>
                <p><strong>Status atual:</strong> {{ $currentStatus }}</p>
                <p><strong>Localização:</strong> {{ $currentLocation }}</p>
                <p><strong>Última atualização:</strong> {{ $updateTime }}</p>
                <p>{{ $statusDescription }}</p>
            </div>

            <h3>Jornada Completa do Pedido</h3>
            
            <div class="journey-container">
                @foreach($journey as $index => $step)
                <div class="journey-step {{ $index === $currentStatusIndex ? 'current-step' : 'completed-step' }}">
                    <div class="step-icon">
                        @if($index === $currentStatusIndex)
                            <img src="{{ asset('images/cargo-truck.svg') }}" alt="Status atual" style="width: 24px; height: 24px;">
                        @else
                            ✓
                        @endif
                    </div>
                    
                    <div class="step-content">
                        <div class="step-title">{{ $step['title'] ?? $step['status'] }}</div>
                        <div class="step-description">{{ $step['description'] }}</div>
                        @if(!empty($step['location']))
                            <div class="step-location">Local: {{ $step['location'] }}</div>
                        @endif
                        <div class="step-date">{{ $step['date'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Botão CTA Adicionado Aqui -->
            <a href="{{ env('APP_URL') }}/rastreio/{{ $trackingCode }}" class="cta-button">Acompanhar Pedido</a>

            <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #777;">
                Precisa de ajuda? <a href="#" style="color: #0056d2;">Fale conosco</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Melhor Rastreio. Todos os direitos reservados.</p>
            <p>
                <a href="#">Política de Privacidade</a> | 
                <a href="#">Termos de Uso</a>
            </p>
        </div>
    </div>
</body>
</html>