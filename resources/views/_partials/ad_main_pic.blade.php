<picture>
    <source srcset="{{ App\Helpers\AdPic::main($ad, '400') }} 2x, {{ App\Helpers\AdPic::main($ad, '200') }} 1x" type="image/webp">
    <img src="{{ App\Helpers\AdPic::main($ad, '200', 'jpg') }}" alt="pic" loading="lazy" width="200" height="150">
</picture>
