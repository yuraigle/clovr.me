<picture>
    <source srcset="{{ App\Helpers\AdPic::main($ad, '400') }}" type="image/webp" media="(min-width: 769px)">
    <source srcset="{{ App\Helpers\AdPic::main($ad, '200') }}" type="image/webp" media="(max-width: 768px)">
    <img src="{{ App\Helpers\AdPic::main($ad, '200', 'jpg') }}" alt="pic" loading="lazy" style="width: 200px">
</picture>
