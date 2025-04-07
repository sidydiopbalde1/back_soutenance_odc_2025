<!DOCTYPE html>
<html>
<head>
    <title>Récompense obtenue</title>
</head>
<body>
    <h2>Bonjour {{ $clientName }}, 🎉</h2>
    <p>
        Suite à votre transaction, vous avez reçu une récompense :
        <strong>{{ $rewardName }}</strong> 🎁
        grâce à la campagne <strong>{{ $campaignName }}</strong>.
    </p>
    <p>Merci de votre fidélité et à bientôt pour d'autres offres !</p>
</body>
</html>
    