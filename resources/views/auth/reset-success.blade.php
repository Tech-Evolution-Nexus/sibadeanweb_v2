<x-guest-layout>
    <div class="text-center mt-8">
        <h2>Password berhasil direset!</h2>
    </div>

    <script>
        if (window.PasswordResetSuccess) {
            PasswordResetSuccess.postMessage("done");
        }
    </script>
</x-guest-layout>