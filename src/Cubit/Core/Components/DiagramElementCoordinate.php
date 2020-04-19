<?php

declare(strict_types=1);

namespace CubitD\Core\Components;


class DiagramElementCoordinate
{
    const LEFT_OF = 'LEFT_OF';
    const TOP_OF = 'TOP_OF';
    const RIGHT_OF = 'RIGHT_OF';
    const BOTTOM_OF = 'BOTTOM_OF';

    /**
     * @var DiagramElementInterface
     */
    private $source;

    /**
     * @var DiagramElementInterface
     */
    private $target;

    /**
     * @var string
     */
    private $relation;

    /**
     * DiagramElementCoordinate constructor.
     * @param DiagramElementInterface $source
     * @param DiagramElementInterface $target
     * @param string $relation
     */
    public function __construct(DiagramElementInterface $source, DiagramElementInterface $target, string $relation)
    {
        $this->source = $source;
        $this->target = $target;
        if (!in_array($relation, [self::LEFT_OF, self::TOP_OF, self::RIGHT_OF, self::BOTTOM_OF])) {
            throw new \InvalidArgumentException('Relation is not valid');
        }
        $this->relation = $relation;
    }

    /**
     * @return DiagramElementInterface
     */
    public function getSource(): DiagramElementInterface
    {
        return $this->source;
    }

    /**
     * @return DiagramElementInterface
     */
    public function getTarget(): DiagramElementInterface
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function getRelation(): string
    {
        return $this->relation;
    }
}
