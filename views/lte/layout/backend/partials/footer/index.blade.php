<div class="kt-footer kt-grid__item" id="kt_footer">
    <div class="kt-container ">
        <div class="kt-footer__wrapper">
            <div class="kt-footer__copyright">
                {{ date('Y') }}&nbsp;&copy;&nbsp; <a href="https://ibraintechs.com" target="_blank" class="kt-link"> iBrain Technologies </a>  &nbsp;{{ config('adminMenu.footer.version') }}
            </div>
            <div class="kt-footer__menu">

                @foreach(config('adminMenu.footer.links') as $link)
                    <a rel="noreferrer" href="{{ $link['link'] }}" target="{{ $link['target'] ? '_blank' : $link['target'] }}" class="{{ $link['class'] }}">{{ __('system.'.$link['title']) }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
