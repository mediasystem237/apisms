<form action="/configurer-webhook" method="POST">
    @csrf
    <label for="webhook">URL Webhook:</label>
    <input type="url" id="webhook" name="webhook" required>
    <button type="submit">Enregistrer</button>
</form>
