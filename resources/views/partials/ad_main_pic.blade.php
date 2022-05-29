<picture>
    <source srcset="{{ App\Helpers\AdPic::main($row, 'm') }}" type="image/webp" media="(min-width: 769px)">
    <source srcset="{{ App\Helpers\AdPic::main($row) }}" type="image/webp" media="(max-width: 768px)">
    <img src="{{ App\Helpers\AdPic::main($row, 'm', 'jpg') }}" alt="pic" loading="lazy">
</picture>
