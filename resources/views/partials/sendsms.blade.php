<!-- Section pour l'envoi rapide de SMS -->
<div class="mt-12 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h2 class="text-2xl font-semibold mb-6 dark:text-white">Envoi rapide de SMS</h2>
    <form action="" method="POST">
        @csrf
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 dark:text-gray-300 mb-2">Numéro de téléphone</label>
            <input type="tel" id="phone" name="phone" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label for="message" class="block text-gray-700 dark:text-gray-300 mb-2">Message</label>
            <textarea id="message" name="message" rows="4" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Envoyer SMS
        </button>
    </form>
</div>