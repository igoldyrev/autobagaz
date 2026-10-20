<form method="POST" action="{{ $crossbarPreferenceAction }}" class="crossbar-preference">
    @csrf
    <input type="hidden" name="owns_crossbars" value="{{ $ownsCrossbars ? '0' : '1' }}">
    <button class="button button__buy product-roof-rack-cross-sell__button" type="submit">{{ $ownsCrossbars ? 'Подобрать багажник' : 'У меня уже есть поперечины' }}</button>
</form>
