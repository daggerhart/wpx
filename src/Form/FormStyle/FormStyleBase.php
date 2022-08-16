<?php

namespace Wpx\Form\FormStyle;

use Wpx\Form\Model\ElementInterface;
use Wpx\Form\Model\FieldInterface;
use Wpx\Form\Model\FormInterface;

/**
 * Form style handles the rendering of the form and fields.
 */
abstract class FormStyleBase implements FormStyleInterface {

	/**
	 * @inheritDoc
	 */
	public function renderFormTemplate( FormInterface $form, string $inner_html ): string {
		return "
		<form {$form->getAttributes()->render()}>
			{$inner_html}
		</form>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldWrapperTemplate( FieldInterface $field, string $field_html, array $descriptors = [] ): string {
		dump($descriptors);
		return "
		<div class='field-wrapper field-type--{$field->getType()} field-id--{$field->getId()}'>
			{$descriptors['before_field']}
			{$field_html}
			{$descriptors['after_field']}
		</div>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldTemplate( FieldInterface $field ): string {
		$element = $field->getElement();
		// Tags that need closing should have content.
		if ( $element->getContent() ) {
			return "<{$element->getTag()} {$element->getAttributes()->render()}>{$element->getContent()}</{$element->getTag()}>";
		}

		return "<{$element->getTag()} {$element->getAttributes()->render()}>";
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldLabelTemplate( FieldInterface $field, ElementInterface $element ): string {
		return $this->renderElement( $element );
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldDescriptionTemplate( FieldInterface $field, ElementInterface $element ): string {
		return $this->renderElement( $element );
	}

	/**
	 * @inheritDoc
	 */
	public function renderFieldHelpTextTemplate( FieldInterface $field, ElementInterface $element ): string {
		return $this->renderElement( $element );
	}


	/**
	 * @inheritDoc
	 */
	public function renderElement( ElementInterface $element ): string {
		if ( $element->isEmpty() ) {
			return '';
		}

		// Tags that need closing should have content.
		if ( $element->getContent() ) {
			return "<{$element->getTag()} {$element->getAttributes()->render()}>{$element->getContent()}</{$element->getTag()}>";
		}

		return "<{$element->getTag()} {$element->getAttributes()->render()}>";
	}

}
