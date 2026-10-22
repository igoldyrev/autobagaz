@props(['id', 'errorBag' => 'default'])

<div class="personal-data-consent">
    <input type="hidden" name="consent_version" value="{{ App\Support\PersonalDataConsent::VERSION }}">
    <label class="personal-data-consent__label" for="{{ $id }}">
        <input id="{{ $id }}" name="personal_data_consent" type="checkbox" value="1" required>
        <span>Даю <a href="{{ route('personal-data-consent') }}" target="_blank" rel="noopener">согласие на обработку персональных данных</a>. <a href="{{ route('privacy-policy') }}" target="_blank" rel="noopener">Политика обработки персональных данных</a>.</span>
    </label>
    @error('personal_data_consent', $errorBag)<p class="personal-data-consent__error" role="alert">{{ $message }}</p>@enderror
    @error('consent_version', $errorBag)<p class="personal-data-consent__error" role="alert">{{ $message }}</p>@enderror
</div>
