<?php declare(strict_types=1);

namespace Shopware\Core\Framework\DataAbstractionLayer\EntityProtection;

use Shopware\Core\Framework\Struct\Collection;

/**
 * @method void                  set(string $key, EntityProtection $entity)
 * @method EntityProtection[]    getIterator()
 * @method EntityProtection[]    getElements()
 * @method EntityProtection|null get(string $key)
 * @method EntityProtection|null first()
 * @method EntityProtection|null last()
 */
class EntityProtectionCollection extends Collection
{
    /**
     * @param EntityProtection $element
     */
    public function add($element): void
    {
        $this->set(get_class($element), $element);
    }
}
