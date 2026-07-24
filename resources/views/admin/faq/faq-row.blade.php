@php
    $faqId = $faqRow->id ?? '';
    $faqQuestion = $faqRow->question ?? '';
    $faqAnswer = $faqRow->answer ?? '';
    $faqStatus = $faqRow->status ?? 1;
@endphp
<div class="faq-item" data-key="{{ $index }}" data-faq-id="{{ $faqId }}">
    <div class="faq-row-line">
        <span class="faq-drag-handle" title="Drag to reorder"><i class="fas fa-grip-vertical"></i></span>

        <input type="hidden" name="faqs[{{ $index }}][id]" value="{{ $faqId }}">

        <input type="text" class="form-control faq-question-input" name="faqs[{{ $index }}][question]"
            placeholder="Question" value="{{ $faqQuestion }}">

        <div class="custom-control custom-switch faq-status-switch" title="Active/Inactive">
            <input type="checkbox" class="custom-control-input" id="faq_status_{{ $index }}"
                name="faqs[{{ $index }}][status]" value="1" @if ($faqStatus) checked @endif>
            <label class="custom-control-label" for="faq_status_{{ $index }}"></label>
        </div>

        <button type="button" class="btn btn-success btn-sm faq-add-btn" title="Add FAQ">
            <i class="fas fa-plus"></i>
        </button>
        <button type="button" class="btn btn-danger btn-sm faq-remove-btn" title="Remove FAQ">
            <i class="fas fa-minus"></i>
        </button>
    </div>
    <div class="faq-body">
        <textarea class="form-control" name="faqs[{{ $index }}][answer]" placeholder="Answer" rows="3">{{ $faqAnswer }}</textarea>
    </div>
</div>
