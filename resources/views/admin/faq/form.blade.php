<x-app-layout :title="$data->title">

    <div class="md:px-12 px-6 md:py-10 py-5">
        <div class="mb-10">
            <div class="text-sm">Dashboard / <a class="hover:underline" href="{{route("faq.index")}}">FAQ</a>
                / <span class="text-gray-700 font-semibold">{{ $data->title }}</span></div>
            <div class="flex">
                <h1 class="text-2xl font-bold">{{$data->title}}</h1>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <form action="<?= $data->action_form ?>" method="POST" class="card" enctype="multipart/form-data">
            @csrf
            @method($data->method)

            <div class="mb-2 ms-md-3">
                <x-input-label for="question" :value="__('Pertanyaan')" />
                <x-text-input :value="old('question', $data->data->question)" type="text" class=" block mt-1 w-full"
                    placeholder="Pertanyaan" name="question" id="question" required />
                <x-input-error :messages="$errors->get('question')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="mb-2 ms-md-3">
                <x-input-label for="answer" :value="__('Jawaban')" />
                <textarea name="answer" id="answer" rows="6"
                    class=" w-full rounded-md border-gray-300 p-4 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mt-1">{{ old('answer', $data->data->answer) }}</textarea>
                <x-input-error :messages="$errors->get('answer')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="flex md:justify-end md:flex-row flex-col-reverse mt-8 gap-4">
                <a href="{{route("faq.index")}}"
                    class="px-4 md:w-auto w-full py-2 bg-slate-200 text-center rounded-md text-gray-900 ">Kembali</a>
                <button type="submit"
                    class="px-4 md:w-auto w-full py-2 bg-[--primary] rounded-md text-white ">Simpan</button>
            </div>
        </form>

    </div>

</x-app-layout>
