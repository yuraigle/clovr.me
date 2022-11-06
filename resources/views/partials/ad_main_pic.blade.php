<picture>
    <source srcset="{{ App\Helpers\AdPic::main($ad, 'm') }}" type="image/webp" media="(min-width: 769px)">
    <source srcset="{{ App\Helpers\AdPic::main($ad) }}" type="image/webp" media="(max-width: 768px)">
    <img src="{{ App\Helpers\AdPic::main($ad, 'm', 'jpg') }}" alt="pic" loading="lazy">
</picture>
