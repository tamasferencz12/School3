import java.util.Objects;

public class Szotar {
    private String element;
    private int code;

    public Szotar(String element, int code) {
        this.element = element;
        this.code = code;
    }

    public String getElement() {
        return element;
    }

    public void setElement(String element) {
        this.element = element;
    }

    public int getCode() {
        return code;
    }

    public void setCode(int code) {
        this.code = code;
    }

    @Override
    public boolean equals(Object o) {
        if (this == o) return true;
        if (o == null || getClass() != o.getClass()) return false;
        Szotar szotar = (Szotar) o;
        return code == szotar.code && Objects.equals(element, szotar.element);
    }

    @Override
    public int hashCode() {
        return Objects.hash(element, code);
    }
}
