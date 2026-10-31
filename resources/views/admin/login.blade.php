<x-layouts.admin title="Log in">

    <form method="POST" action="{{ route('login') }}" class="mx-auto flex max-w-110 flex-col gap-5 rounded-2xl border border-line bg-surface p-6 sm:p-8">
        @csrf
        <h1 class="font-serif text-h2 font-semibold">Log in</h1>

        <x-input name="email" label="Email" type="email" autocomplete="username" required autofocus />
        <x-input name="password" label="Password" type="password" autocomplete="current-password" required />

        <label class="flex items-center gap-2">
            <input type="checkbox" name="remember" value="1" class="size-5 accent-brand">
            Keep me logged in
        </label>

        <x-button class="w-full">Log in</x-button>
    </form>

</x-layouts.admin>
