<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestContoller extends AbstractController {
    /**
     * @Route("/{amount}", name="test")
     *
     * @param int $amount
     * @throws \Exception
     */
    public function Test(int $amount) {
        echo 'Amount : '.$amount."<br/><br/>";

        echo 'Generating normal PHP array ... :'."<br/>";
        $normalList = $this->generateNormalList($amount);
        echo 'Done'."<br/><br/>";

        echo 'Generating Double Linked List ... '."<br/>";
        $doubleLinkedList = $this->generateDoublyLinkedList($amount);
        echo 'Done'."<br/><br/>";

        echo 'Ready to start \"insert\" test in the middle of the array (index '.($amount/2).') ...'."<br/><br/>";
        echo '-----------------------------------'."<br/><br/>";
        echo 'Normal PHP array ... '."<br/>";
        $execTimeArray = $this->arrayInsertIndex($normalList, ($amount/2), random_int(0, 100));
        echo 'Execution time : '.$execTimeArray.' ms'."<br/><br/>";

        echo '-----------------------------------'."<br/><br/>";
        echo 'Double Linked List ... '."<br/>";
        $execTimeDoublyLinkedList = $this->doublyLinkedListInsertIndex($doubleLinkedList, ($amount/2), random_int(0, 100));
        echo 'Execution time : '.$execTimeDoublyLinkedList.' ms'."<br/><br/>";

        return new Response();
    }

    private function generateNormalList(int $amount): array {
        return array_fill(0, $amount, random_int(1, 100));
    }

    private function generateDoublyLinkedList(int $amount): \SplDoublyLinkedList {
        $list = new \SplDoublyLinkedList();

        for ($i = 0; $i < $amount; $i ++) {
            $list->add($i, random_int(1, 100));
        }

        return $list;
    }

    private function arrayInsertIndex (array $array, int $index, int $value): float {
        $timeStart = microtime(true);

        for ($i = count($array) - 1; $i >= $index ; $i -- ) {
            $array[$i + 1] = $array[$i];
        }

        $array[$index] = $value;

        $timeEnd = microtime(true);

        return ($timeEnd - $timeStart) * 1000;
    }

    private function doublyLinkedListInsertIndex(\SplDoublyLinkedList $list, int $index, int $value): float {
        $timeStart = microtime(true);

        $list->add($index, $value);

        $timeEnd = microtime(true);

        return ($timeEnd - $timeStart) * 1000;
    }
}