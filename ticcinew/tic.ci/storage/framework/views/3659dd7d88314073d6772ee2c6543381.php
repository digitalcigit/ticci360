<tr data-locale="<?php echo e($item['locale']); ?>">
    <td class="text-start">
        <span><?php echo e($item['name']); ?></span>
    </td>
    <td><?php echo e($item['locale']); ?></td>
    <td><?php echo e($item['locale'] == app()->getLocale() ? trans('core/base::base.yes') : trans('core/base::base.no')); ?></td>
    <td>
        <div class="btn-list justify-content-end">
            <?php if (isset($component)) { $__componentOriginal922f7d3260a518f4cf606eecf9669dcb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal922f7d3260a518f4cf606eecf9669dcb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8def1252668913628243c4d363bee1ef::button','data' => ['tag' => 'a','href' => route('translations.locales.download', $item['locale']),'class' => 'download-locale-button','tooltip' => trans('plugins/translation::translation.download'),'icon' => 'ti ti-download','iconOnly' => true,'color' => 'primary','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('core::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'a','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('translations.locales.download', $item['locale'])),'class' => 'download-locale-button','tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trans('plugins/translation::translation.download')),'icon' => 'ti ti-download','icon-only' => true,'color' => 'primary','size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal922f7d3260a518f4cf606eecf9669dcb)): ?>
<?php $attributes = $__attributesOriginal922f7d3260a518f4cf606eecf9669dcb; ?>
<?php unset($__attributesOriginal922f7d3260a518f4cf606eecf9669dcb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal922f7d3260a518f4cf606eecf9669dcb)): ?>
<?php $component = $__componentOriginal922f7d3260a518f4cf606eecf9669dcb; ?>
<?php unset($__componentOriginal922f7d3260a518f4cf606eecf9669dcb); ?>
<?php endif; ?>
            <?php if($item['locale'] !== 'en'): ?>
                <?php if (isset($component)) { $__componentOriginal922f7d3260a518f4cf606eecf9669dcb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal922f7d3260a518f4cf606eecf9669dcb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '8def1252668913628243c4d363bee1ef::button','data' => ['type' => 'button','dataUrl' => route('translations.locales.delete', $item['locale']),'class' => 'delete-locale-button','tooltip' => trans('plugins/translation::translation.delete'),'icon' => 'ti ti-trash','iconOnly' => true,'color' => 'danger','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('core::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','data-url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('translations.locales.delete', $item['locale'])),'class' => 'delete-locale-button','tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trans('plugins/translation::translation.delete')),'icon' => 'ti ti-trash','icon-only' => true,'color' => 'danger','size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal922f7d3260a518f4cf606eecf9669dcb)): ?>
<?php $attributes = $__attributesOriginal922f7d3260a518f4cf606eecf9669dcb; ?>
<?php unset($__attributesOriginal922f7d3260a518f4cf606eecf9669dcb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal922f7d3260a518f4cf606eecf9669dcb)): ?>
<?php $component = $__componentOriginal922f7d3260a518f4cf606eecf9669dcb; ?>
<?php unset($__componentOriginal922f7d3260a518f4cf606eecf9669dcb); ?>
<?php endif; ?>
            <?php endif; ?>
        </div>
    </td>
</tr>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/plugins/translation/resources/views/partials/locale-item.blade.php ENDPATH**/ ?>