<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Cadastrado com Sucesso</title>
    <style>
        /* Mantemos os mesmos estilos do email anterior para consistência */
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
        .status-timeline {
            background-color: #f9fafb;
            border: 1px solid #e0e4e8;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .timeline-item {
            display: flex;
            align-items: center;
            margin: 15px 0;
        }
        .timeline-icon {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background-color: #0056d2;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
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
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <img src="https://melhorrastreio.com.br/mr-logo.svg" alt="Logo Melhor Rastreio">
            <h1>Pedido Registrado com Sucesso!</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Olá, {{ $nome }}!</h2>
            <p>Seu pedido foi recebido e está em processamento. Estamos trabalhando para preparar seu envio!</p>

            <div class="status-timeline">
                <div class="timeline-item">
                    <div class="timeline-icon">1</div>
                    <div>
                        <p><strong>Primeiro passo:</strong> Pedido registrado em nosso sistema</p>
                        <small>{{ now()->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">2</div>
                    <div>
                        <p><strong>Próximo passo:</strong> Emissão do código de rastreio</p>
                        <small>Você será notificado por email</small>
                    </div>
                </div>
            </div>

            <p>Assim que seu pacote for despachado, enviaremos:</p>
            <ul>
                <li>Código de rastreio completo</li>
                <li>Previsão de entrega atualizada</li>
                <li>Atualizações em tempo real do transporte</li>
            </ul>

            <p style="text-align: center; margin-top: 80px;">Em caso de dúvidas, nossa equipe está disponível</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Melhor Rastreio. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>