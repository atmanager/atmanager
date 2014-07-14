<?php
namespace ATManager\FrontendBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use PatrimonioBundle\Entity\Patrimonio;

class PatrimonioToNumberTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($patrimonio)
    {
        if (null === $patrimonio) {
            return "";
        }

        return $patrimonio->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $number
     *
     * @return Issue|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $patrimonio = $this->om
            ->getRepository('PatrimonioBundle:Patrimonio')
            ->findOneBy(array('id' => $id))
        ;

        if (null === $patrimonio) {
            throw new TransformationFailedException(sprintf(
                'An Patrimonio with number "%s" does not exist!',
                $patrimonio
            ));
        }

        return $patrimonio;
    }
}