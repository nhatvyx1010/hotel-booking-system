<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, bạn vui lòng xác nhận email bằng cách nhấp vào liên kết chúng tôi vừa gửi cho bạn. Nếu bạn chưa nhận được email, chúng tôi sẽ gửi lại cho bạn.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Một liên kết xác nhận mới đã được gửi đến địa chỉ email bạn đã cung cấp khi đăng ký.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Gửi lại email xác nhận') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Đăng xuất') }}
            </button>
        </form>
    </div>
</x-guest-layout>
