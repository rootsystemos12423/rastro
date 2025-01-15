<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Rastreamento Está Disponível</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fafbfc;
            color: #333333;
        }
        .email-container {
            max-width: 700px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #f9f9f9;
            padding: 30px;
            text-align: center;
            color: #2bc866;
        }
        .email-header img {
            max-width: 120px;
            margin-bottom: 10px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            line-height: 1.4;
        }
        .email-body {
            padding: 30px 20px;
        }
        .email-body h2 {
            font-size: 22px;
            color: #0056d2;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.6;
            color: #666666;
            margin: 15px 0;
        }
        .tracking-info {
            background-color: #f9fafb;
            border: 1px solid #e0e4e8;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .tracking-info p {
            margin: 10px 0;
            font-size: 16px;
            font-weight: bold;
            color: #333333;
        }
        .tracking-info strong {
            color: #0056d2;
        }
        .tracking-info-code {
            background-color: #f9fafb;
            border: 1px solid #e0e4e8;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            text-align: center;
        }
        .tracking-info-code p {
            margin: 10px 0;
            font-size: 24px;
            font-weight: bold;
            color: #333333;
        }
        .tracking-info-code strong {
            color: #0056d2;
            font-size: 28px;
        }
        .cta-button {
            display: block;
            text-align: center;
            margin: 30px auto;
            background-color: #0056d2;
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            padding: 14px 40px;
            border-radius: 30px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            max-width: 300px;
        }
        .cta-button:hover {
            background-color: #0043a7;
        }
        .email-footer {
            background-color: #f9fafb;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777777;
        }
        .email-footer a {
            color: #0056d2;
            text-decoration: none;
            font-weight: bold;
        }
        @media screen and (max-width: 768px) {
            .email-container {
                max-width: 90%;
                margin: 20px auto;
            }
            .email-body {
                padding: 20px;
            }
            .cta-button {
                width: 100%;
                padding: 12px 20px;
            }
            .email-header h1 {
                font-size: 24px;
            }
            .email-body h2 {
                font-size: 20px;
            }
        }
        @media screen and (max-width: 480px) {
            .email-header img {
                max-width: 90px;
            }
            .email-header h1 {
                font-size: 20px;
            }
            .email-body p, .tracking-info p {
                font-size: 14px;
            }
            .cta-button {
                font-size: 16px;
                padding: 10px 5px;
            }
            .tracking-info-code strong {
                  font-size: 16px;
            }

        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <img src="https://melhorrastreio.com.br/mr-logo.svg" alt="Logo Melhor Rastreio">
            <h1>Rastreamento Disponível</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Olá, {{ $nome }}!</h2>
            <p>Temos ótimas notícias! Seu pedido foi enviado e está a caminho. Confira os detalhes abaixo:</p>

            <span>Seu código de rastreio é:</span>
            <div class="tracking-info-code">
                  <strong>{{ $trackingCode }}</strong>
              </div>

            <!-- Tracking Information -->
            <div class="tracking-info">
                <p>Transportadora: <strong>Fast Logistica S/A</strong></p>
                <p>Status Atual: <strong>Aguardando Coleta</strong></p>
            </div>

            <p>Para acompanhar o progresso do seu pedido em tempo real, clique no botão abaixo:</p>

            <!-- Call-to-Action Button -->
            <a style="color: white;" href="{{ env('APP_URL') }}/rastreio/{{ $trackingCode }}" class="cta-button">Acompanhar Rastreamento</a>

            <p>Caso tenha dúvidas ou precise de suporte, nossa equipe está pronta para ajudar. Entre em contato pelo link abaixo.</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Melhor Rastreio. Todos os direitos reservados.</p>
            <p><a href="#">Clique aqui para suporte</a></p>
        </div>
    </div>
</body>
</html>
