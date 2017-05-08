<?php

/**
 * Description of WriteXML
 *
 * @author Mario Costa <mario@computech-it.co.uk>
 */
class WriteXML {

    /**
     * 
     * @param array $nodes
     * @param string $xml
     * @param string $xmlRoot
     * @return \DOMDocument
     */
    public function readArray($nodes, $xml, $xmlRoot) {
        foreach ($nodes as $key => $value) {
            if (!is_array($value)) {
                $xmlNode = $xml->createElement($key, $value);
            } else {
                $xmlNode = $xml->createElement($key);
                $this->readArray($value, $xml, $xmlNode);
            }
            $xmlRoot->appendChild($xmlNode);
        }
        return $xmlRoot;
    }

    /**
     * 
     * @param type $nodes
     * @param type $root
     * @return \DOMDocument
     */
    public function writeToFile($nodes, $root) {
        $xml = new DOMDocument();
        $xmlRoot = $xml->createElement($root);
        $this->readArray($nodes, $xml, $xmlRoot);
        $xml->appendChild($xmlRoot);
        return $xml;
    }

    /**
     * Change the name of the node
     * @param string $item
     * @param string $name
     */
    public function changeNodeName($item, $name) {
        $newNode = $item->ownerDocument->createElement($name);
        if ($item->attributes->length) {
            foreach ($item->attributes as $attribute) {
                $newNode->setAttribute($attribute->nodeName, $attribute->nodeValue);
            }
        }
        while ($item->firstChild) {
            $newNode->appendChild($item->firstChild);
        }
        $item->parentNode->replaceChild($newNode, $item);
    }

}
